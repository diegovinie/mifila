<template lang="html">
  <div class="">
      <div class="title">

      </div>
      <div class="row">
          <div class="left">

          </div>
          <div class="center">
              <Summary :globals="globals"></Summary>
          </div>
          <div class="right">

          </div>
      </div>
      <div class="row">
          <div class="center">

          </div>
      </div>
  </div>
</template>

<script>
import Summary from './Summary'

export default {
    data: () => ({
        globals: {
            queue: null,
            cashiers: null,
            finished: null
        }
    }),

    components: {
        Summary
    },

    methods: {
        fetch () {
            console.log('en fetch')
            axios.get('/api/v1/globals')
                .then(({data}) => {
                    console.log(data)
                    this.globals = data
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
