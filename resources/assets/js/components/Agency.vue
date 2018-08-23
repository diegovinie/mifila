<template lang="html">
  <div class="col-xs-12 col-sm-6 col-lg-4">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h4>{{ name }}</h4>
          </div>
          <div class="panel-body">
              <ul class="list-group">
                  <li class="list-group-item">
                      <span>Cajeros: {{ cashiers }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Clientes en espera: {{ queue }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Total atendidos: {{ finished }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Tiempo de espera: {{ avg }} seg.</span>
                  </li>
                  <li class="list-group-item">
                      <span>Atendiendo a: {{ lastCalled }}</span>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    data: () => ({
        name: null,
        cashiers: null,
        queue: null,
        finished: null,
        avg: null,
        lastCalled: null
    }),

    props: [
        'id'
    ],

    methods: {
        fetch () {
            axios.get('/api/v1/agencies/' + this.id + '/info')
                .then(({data}) => {
                    this.name      = data.name
                    this.cashiers  = data.cashiers
                    this.queue     = data.queue
                    this.finished  = data.finished
                    this.avg       = data.avg
                    this.lastCalled = data.lastCalled
                })
                .catch(err => {
                    console.log('error fetch de Agency '+this.id, err)
                })
        }
    },

    created () {
        this.fetch()

        setInterval(() => {
            this.fetch()
        }, 5000)
    }
}
</script>

<style lang="css">
</style>
