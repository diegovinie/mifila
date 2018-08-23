<template lang="html">
  <div class="">
      <div class="row">
          <h2>Simulador de cola</h2>
      </div>
      <div class="row align-items-center">
          <div class="col-xl-8 col-lg-7">
              <Summary :globals="globals"></Summary>
          </div>
      </div>
      <div class="row">
          <template v-for="agency in agencies" >
              <Agency
                :id="agency.id" />
          </template>
      </div>
      <div class="row">
          <div class="center">

          </div>
      </div>
  </div>
</template>

<script>
import Summary from './Summary'
import Agency from './Agency'

export default {
    data: () => ({
        globals: {
            queue: null,
            cashiers: null,
            finished: null,
            avg: null
        },
        agencies: []
    }),

    components: {
        Summary,
        Agency
    },

    methods: {
        fetch () {
            console.log('en fetch')
            axios.get('/api/v1/globals')
                .then(({data}) => {
                    console.log(data)
                    this.globals = data
                    this.agencies = data.agencies
                })
                .catch(err => {
                    console.log('error en fetch: ', err)
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
