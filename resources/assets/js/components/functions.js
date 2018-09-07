
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

export var acchours = {
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
		var acc = 0
    return response.map(hour => acc = hour + acc)
	}
}
