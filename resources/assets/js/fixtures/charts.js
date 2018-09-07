export const chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
}

export const config = {
  type: 'line',
  data: {
    labels: [],
    datasets: [
      {
       label: 'Tickets pedidos',
       backgroundColor: chartColors.red,
       borderColor: chartColors.red,
       data: [],
       fill: false,
      },
      {
       label: 'Tickets atendidos',
       fill: false,
       backgroundColor: chartColors.blue,
       borderColor: chartColors.blue,
       data: [],
      }
    ]
  },
  options: {
   responsive: true,
   title: {
     display: true,
     text: 'El título'
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
