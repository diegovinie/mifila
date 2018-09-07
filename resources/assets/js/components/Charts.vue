<template lang="html">
  <div class="">
    <div style="height:60px;">

    </div>
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="form-inline">
        <div class="form-group">
          <label for="globals">Cobertura:</label>
          <select @change="fetch()" class="form-control" v-model="cob">
            <option value="0">Global</option>
            <template v-for="agency in agencies" >
              <option :value="agency.id">{{ agency.name }}</option>
            </template>
          </select>
        </div>
        <div class="form-group">
          <label for="temp">Por día:</label>
          <select @change="fetch()" class="form-control" v-model="daysoffset">
            <option value="0">Hoy</option>
            <option value="1">Ayer</option>
          </select>
        </div>
      </div>
      <canvas id="perHour" max-width="300" max-height="300"></canvas>
      <canvas id="accHour" max-width="300" max-height="300"></canvas>
    </div>

  </div>
</template>

<script>
// import ChartPattern from './ChartPattern'
import Chart from 'chart.js'
import {byhours, acchours} from './functions'
import {config, chartColors} from '../fixtures/charts'

export default {
  data: () => ({
    perHour: {
      config : JSON.parse(JSON.stringify(config))
    },
    accHour: {
      config: JSON.parse(JSON.stringify(config))
    },
    cob:0,
		daysoffset: 0,
    agencies: [],
  }),

	computed: {
		day: function () {
			let today = new Date()
			let dayms = 1000*60*60*24
			today.setTime(today.getTime() - dayms * this.daysoffset)

			return `${today.getFullYear()}-${today.getMonth() +1}-${today.getDate()}`
		},

    ticketsUrl: function () {
      if (this.cob) {
        return `agencies/${this.cob}/tickets`
      }
      return 'tickets'
    },

    servicesUrl: function () {
      if (this.cob) {
        return `agencies/${this.cob}/services`
      }
      return 'globals/services'
    }
	},

  methods: {
    fetchAgencies () {
        axios.get('agencies')
          .then(({data}) => {
            this.agencies = data
          })
          .catch(err => {
            console.log(err)
          })
    },

    async fetch () {
      this.perHour.config.data.labels = byhours.xdata()
      this.perHour.config.options.title.text = 'Turnos por hora'
      this.perHour.config.type = 'bar'

      await axios.get(`${this.ticketsUrl}?day=${this.day}`)
        .then(({data}) => {
          this.perHour.config.data.datasets[0].data = byhours.ydata(data)
          this.accHour.config.data.datasets[0].data = acchours.ydata(data)
        })
        .catch(err => {
          console.log('Error en fetch: ', err)
        })


      await axios.get(`${this.servicesUrl}?day=${this.day}`)
        .then(({data}) => {
          this.perHour.config.data.datasets[1].data = byhours.ydata(data)
          this.accHour.config.data.datasets[1].data = acchours.ydata(data)
        })
        .catch(err => {

				})

        this.accHour.config.data.labels = byhours.xdata()
        this.accHour.config.options.title.text = 'Acumulado'

			if (window.charts) {
        for (let chart in window.charts) {
          window.charts[chart].update()
        }
      }
    }
  },

  async created () {
    this.fetchAgencies()
    await this.fetch()

    setInterval(() => {
      this.fetch()
    }, 60*1000)
  },

  mounted () {
    window.charts = {}
    window.charts.perHour = new Chart(document.getElementById('perHour'), this.perHour.config)
    window.charts.accHour = new Chart(document.getElementById('accHour'), this.accHour.config)
  }
}
</script>

<style lang="css">
</style>
