<template lang="html">
  <div class="">
    <div class="row">
      <div class="col-xs-12">
        <h2>Simulador de cola</h2>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-md-offset-1 col-md-6 col-xs-12">
        <SimControls :globals="globals" :agencies="agencies" />
      </div>
      <div class=" col-md-4 col-xs-12">
        <Summary :globals="globals" />
      </div>
    </div>
  </div>
</template>

<script>
import Summary from './Summary'
import SimControls from './SimControls'
import store from '../store'

export default {
  computed: {
    globals: () => store.state.globals,
    agencies: () => store.state.agencies
  },

  components: {
    Summary,
    SimControls
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
    },
    fetchAgencies () {
      axios.get('globals/agencies')
        .then(({data}) => {
          store.commit('SET_AGENCIES', data)
        })
        .catch(err => {
          console.log('Error en fetchAgencies ', err)
        })
    }
  },

  created () {
    this.fetch()
    this.fetchAgencies()
  }
}
</script>

<style lang="css">
</style>
