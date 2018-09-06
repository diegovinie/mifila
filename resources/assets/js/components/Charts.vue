<template lang="html">
  <div class="">
    <div style="height:60px;">

    </div>
    <select class="form-control">
      <option value="0">Global</option>
      <template v-for="agency in agencies" >
        <option :value="agency.id">{{ agency.name }}</option>
      </template>
    </select>
		<select @change="fetch()" class="form-control" v-model="daysoffset">
      <option value="0">Hoy</option>
			<option value="1">Ayer</option>
    </select>
    <ChartPattern
      v-if="active"
      id="11"
      :config="config"
    />

  </div>
</template>

<script>
import ChartPattern from './ChartPattern'
import {byhours} from './functions'

export default {
  data: () => ({
			active: false,
			daysoffset: 0,
      agencies: [],
      config: {
  			type: 'line',
  			data: {
  				labels: [],
  				datasets: [
  				{
  					label: 'Tickets pedidos',
  					backgroundColor: window.chartColors.red,
  					borderColor: window.chartColors.red,
  					data: [],
  					fill: false,
  				},
  				{
  					label: 'Tickets atendidos',
  					fill: false,
  					backgroundColor: window.chartColors.blue,
  					borderColor: window.chartColors.blue,
  					data: [],
  				}
  			]
  			},
  			options: {
  				responsive: true,
  				title: {
  					display: true,
  					text: 'Turnos por hora'
  				},
  				tooltips: {
  					mode: 'index',
  					intersect: false,
  				},
  				hover: {
  					mode: 'nearest',
  					intersect: true
  				},
  				scales: {
  					xAxes: [{
  						display: true,
  						scaleLabel: {
  							display: true,
  							labelString: 'Hora (24h)'
  						}
  					}],
  					yAxes: [{
  						display: true,
  						scaleLabel: {
  							display: false,
  							labelString: 'tickets'
  						}
  					}]
  				}
  			}
  		}
  }),
  components: {
    ChartPattern
	},
	
	computed: {
		day: function () {
			let today = new Date()
			let dayms = 1000*60*60*24
			today.setTime(today.getTime() - dayms * this.daysoffset)

			return `${today.getFullYear()}-${today.getMonth() +1}-${today.getDate()}`
		}
	},

  methods: {
    async fetch () {
      this.config.data.labels = byhours.xdata()

      await axios.get(`tickets?day=${this.day}`)
        .then(({data}) => {
          this.config.data.datasets[0].data = byhours.ydata(data)
        })
        .catch(err => {
          console.log('Error en fetch: ', err)
        })

      await axios.get(`globals/services?day=${this.day}`)
        .then(({data}) => {
          this.config.data.datasets[1].data = byhours.ydata(data)
        })
        .catch(err => {

				})
			if (window.chart) window.chart.update()
    }
  },

  async created () {
    await this.fetch()
    this.active = true

    setInterval(() => {
      this.fetch()
    }, 60*1000)
  }
}
</script>

<style lang="css">
</style>
