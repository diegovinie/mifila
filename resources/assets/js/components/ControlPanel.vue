<template lang="html">
  <div class="">
      <div class="row">
          <h2>Simulador de cola</h2>
      </div>
      <div class="row align-items-center">
          <div class="col-lg-4 col-md-6 col-xs-12">
              <Summary :globals="globals"></Summary>
          </div>
          <div class="col-lg-4 col-md-6 col-xs-12">
            <SimControls />
            <template v-for="agency in globals.agencies" >
                <AgencySim
                :agency="agency" />
            </template>
          </div>
      </div>
      <div class="row">
          <template v-for="agency in globals.agencies" >
              <div class="col-lg-3 col-md-4 col-xs-12" >
                <Agency
                    :agency="agency" />
              </div>
          </template>
      </div>
  </div>
</template>

<script>
import Summary from './Summary'
import Agency from './Agency'
import SimControls from './SimControls'
import AgencySim from './AgencySim'
import store from '../store'

export default {
    data: () => ({

    }),

    computed: {
        globals: () => store.state.globals
    },

    components: {
        Summary,
        Agency,
        SimControls,
        AgencySim
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
