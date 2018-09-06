<template lang="html">
  <div class="">
    <div style="height:60px;">

    </div>
    <select class="form-control" name="">
      <option value="0">Global</option>
      <template v-for="agency in agencies" >
        <option :value="agency.id">{{ agency.name }}</option>
      </template>
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

  methods: {
    async fetch () {
      this.config.data.labels = byhours.xdata()

      await axios.get('tickets')
        .then(({data}) => {
          this.config.data.datasets[0].data = byhours.ydata(data)
        })
        .catch(err => {
          console.log('Error en fetch: ', err)
        })

      await axios.get('globals/services')
        .then(({data}) => {
          this.config.data.datasets[1].data = byhours.ydata(data)
        })
        .catch(err => {

        })
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
