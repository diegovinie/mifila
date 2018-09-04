<template lang="html">
  <div>
    <div class="row">
      <div class="col-xs-12 block-one">

      </div>

      <div class="col-md-offset-3 col-md-6 col-xs-12">
        <h3>Seguimiento a tickes activos:</h3>
        <div v-if="!activateTicket">
          <ul class="list-group">
            <template v-for="ticket in tickets" >
              <a href @click.prevent="showTicket(ticket)" >
                <li class="list-group-item" :key="ticket.id">
                  <span>{{ ticket.agency.name }}</span>
                  <span>{{ ticket.num }}</span>
                </li>
              </a>
            </template>
          </ul>
        </div>
        <div v-if="activateTicket">
          <Ticket
            @closeTicket="activateTicket = false"
            :ticket="theTicket" />
        </div>
      </div>
    </div>
    <div class="row">
      <div 
        v-if="!selectActive" 
        class="col-md-offset-3 col-md-6 col-xs-12">
        <button 
          class="btn btn-primary btn-block"
          @click="getAgencies()" >
          Pedir un turno
        </button>
      </div>
      <div 
        class="col-xs-12 col-md-6 col-md-offset-3" 
        v-if="selectActive" >
          <h2>Elige una agencia:</h2>
          <div class="panel-group" id="accordion">
            <template v-for="agency in agencies" >
              <Agency
                :key="agency.id"
                :agency="agency"
                class="panel panel-primary"/>
            </template>
          </div>
          <button 
            class="btn btn-default"
            @click="selectActive = false" >
            Regresar
          </button>
      </div>
    </div>
  </div>
</template>

<script>
import Agency from './SimControls/Agency'
import Ticket from './Ticket'

export default {
  data: () => ({
    clientid: 1127606049,
    selectActive: false,
    agencies: [],
    tickets: [],
    theTicket: {},
    activateTicket: false
  }),

  computed: {},

  components: {
    Agency,
    Ticket
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
    },

    getTickets () {
      axios.get(`clients/${this.clientid}/tickets`)
        .then(({data}) => {
          this.tickets = data
        })
        .catch(err => {
          console.log('Error getTicket ', err)
        })
    },

    showTicket (ticket) {
      this.theTicket = ticket
      this.activateTicket = true
    }
  },

  created () {
    this.getTickets()
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
