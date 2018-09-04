<template lang="html">
  <div>
    <div class="row">
      <div class="col-xs-12 block-one">

      </div>

      <div class="col-xs-12 block-two">
        <h2>Elige una agencia:</h2>
      </div>
    </div>
    <div class="row block-three">
      <div v-if="!selectActive" class="col-md-offset-1 col-md-6 col-xs-12">
        <button 
          class="btn btn-primary btn-block"
          @click="getAgencies()" >
          Pedir un turno
        </button>
      </div>
      <div clas="col-xs-12" v-if="selectActive" >
          <div class="panel-group" id="accordion">
            <template v-for="agency in agencies" >
              <Agency
                :key="agency.id"
                :agency="agency"
                class="panel panel-primary"/>
            </template>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import Agency from './SimControls/Agency'

export default {
  data: () => ({
    selectActive: false,
    agencies: []
  }),

  components: {
    Agency
  },

  methods: {
    getAgencies () {
      axios.get('globals/agencies')
        .then(({data}) => {
          this.agencies = data
          this.selectActive = true
        })
        .catch(err => {
          console.log('Error getAgencies', err)
        })
    }
  }
}
</script>

<style lang="css">
  .block-one {
    background-color: aquamarine;
    height: 60px;
  }

  .block-two {
    background-color:brown;
    height: 120px;
  }
  .block-three {
    background-color: greenyellow;
    height: 40px;
  }
</style>
