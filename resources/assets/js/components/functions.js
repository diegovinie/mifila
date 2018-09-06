window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
}

export var byhours = {
  xdata: function () {
    let res = []
    res.length = 24
    res.fill(0)

    return res.map((obj, key) => key)
  },

  ydata: function (data) {

    var tickets = data.map((ticket) => {
        ticket.time = (new Date(ticket.created_at)).getHours()
        return ticket
    })

    var response = []
    response.length = 24
    response.fill(0)
    var values = _.groupBy(tickets, 'time')
    console.log(values)

    for (let i in values) {
      response[i] = values[i].length
    }

    return response
  }
}
