<template lang="html">
  <div class="row">
      <span>{{ name }}</span>
      <br />
      <span>Cajeros: {{ cashiers }}</span>
      <br />
      <span>Atendiendo a: {{ lastCalled }}</span>
      <br />
      <span>Clientes en espera: {{ queue }}</span>
      <br />
      <span>Total atendidos: {{ finished }}</span>
      <br />
      <span>Tiempo de espera: {{ avg }} seg.</span>
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
