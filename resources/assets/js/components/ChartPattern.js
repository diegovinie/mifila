import Chart from 'chart.js'

export default {
  props: [
    'config',
    'id'
  ],

  template: `<canvas
              :id="id"
              max-width="300" max-height="300"></canvas>`,

  mounted () {
    const canvas = document.getElementById(this.id)
    window.chart = new Chart(canvas, this.config)
  }
}
