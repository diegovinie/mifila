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
          <template v-for="agency in globals.agencies" >
              <Agency
                :agency="agency" />
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
import store from '../store'

export default {
    data: () => ({

    }),

    computed: {
        globals: () => store.state.globals
    },

    components: {
        Summary,
        Agency
    },

    methods: {
        fetch () {
            axios.get('globals')
                .then(({data}) => {
                    // console.log(data)
                    store.commit('UPDATE_GLOBALS', data)
                })
                .catch(err => {
                    console.log('error en fetch: ', err)
                })
        }
    },

    created () {
        this.fetch()
    }
}
</script>

<style lang="css">
</style>
