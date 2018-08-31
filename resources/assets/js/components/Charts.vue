<template lang="html">
  <div class="">
      <canvas id="canvas" max-width="300" max-height="300"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js'

export default {
  data: () => ({
      sum: []
  }),

  methods: {
    fetch () {
      axios.get('tickets')
      .then(({data}) => {
        console.log(data)

        var res = data.map((ticket) => {
            ticket.time = (new Date(ticket.created_at)).getHours()
            return ticket
        })

        var b = _(res).groupBy('time').map((obj, key) => {
          return {
            'time': key,
            'value': _.sumBy(obj, 'time')
          }
        }).value()

        var arr = []
        arr.length = 24
        arr.fill(0)
        b.forEach(item => arr[item.time] = item. value)



        console.log(arr)
        console.log(b)

        const canvas = document.getElementById('canvas')

        window.chart2 = new Chart(canvas, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: arr,
                datasets: [{
                    label: "My First dataset",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: arr
                }]
            },

            // Configuration options go here
            options: {}
        });
        this.sum = arr
      })
      .catch(err => {
        console.log('Error en fetch: ', err)
      })
    }
  },

  mounted () {
      const canvas = document.getElementById('canvas')

      // window.firstChart = new Chart(canvas, {
      //     type: 'line',
      //     datasets: [
      //       {
      //         data: this.sum
      //
      //       }
      //     ]
      //
      // })


  },

  async created () {
    await this.fetch()
  }
}
</script>

<style lang="css">
</style>
