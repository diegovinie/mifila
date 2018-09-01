<template lang="html">
  <div class="">
    <div class="row">
      <div class="col-xs-12">
        <h2>Simulador de cola</h2>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-offset-1 col-lg-6 col-md-8 col-xs-12">
        <SimControls :globals="globals" />
      </div>
      <div class="col-lg-3 col-md-4 col-xs-12">
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
    globals: () => store.state.globals
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
    }
  },

  created () {
    this.fetch()
  }
}
</script>

<style lang="css">
</style>
