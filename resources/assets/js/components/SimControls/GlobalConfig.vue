<template lang="html">
  <div id="globals">
    <div class="checkbox">
        <label>
          <input
            type="checkbox"
            readonly
            v-model="simActive"
            >
            Simulador Activo
        </label>
    </div>
    <div class="form-group">
      <label for="acc">Acceleración:</label>
      <select
        class="form-control"
        id="acc"
        name="acc"
        v-model="newAcc"
        @change="updateAcc()"
        >
        <template v-for="acc in accs" >
          <option :value="acc.id" :key="acc.id" >{{ acc.name }} </option>
        </template>
      </select>
    </div>
    <div class="form-group">
      <label for="noti">Probabilidad de notificar:</label>
      <select
        class="form-control"
        id="noti"
        name="noti"
        v-model="newNoti"
        @change="updateNoti()"
        >
        <template v-for="noti in notis" >
          <option :value="noti.id" :key="noti.id" >{{ noti.name }} </option>
        </template>
      </select>
    </div>
    <div class="form-group">
      <label for="clients_rate">Promedio de Clientes:</label>
      <select
        class="form-control"
        id="clients_rate"
        v-model="newClientsRate"
        name="clients_rate"
        @change="updateClientsRate()"
        >
        <template v-for="rate in clientsRates">
          <option :key="rate.id" :value="rate.id">{{ rate.name }}</option>
        </template>
      </select>
    </div>
    <SimActions />
  </div>
</template>

<script>
import SimActions from './SimActions'

export default {
  data: () => ({
    newAcc: null,
    newClientsRate: null,
    newNoti: null,
    accs: [],
    notis: [],
    clientsRates: []
  }),

  components: {
    SimActions  
  },

  props: ['simActive'],

  methods: {
    fetchConfigs () {
      axios.get('configs')
        .then(({data}) => {
          data.forEach(config => {
            // console.log(config.name)
            if (config.name === 'acc') {
              this.newAcc = config.current.id
            }
            if (config.name === 'clients_rate') {
              this.newClientsRate = config.current.id
            }
            if (config.name === 'noti_prob') {
              this.newNoti = config.current.id
            }
          })
          this.configs = data
        })
        .catch(err => {
          console.log('Error ', err)
        })
    },

    fetchAccs () {
      axios.get('configs/2/items')
        .then(({data}) => {
          this.accs = data
        })
        .catch(err => {
          console.log('Error fetchAccs ', err)
        })
    },

    fetchClientsRates () {
      axios.get('configs/1/items')
        .then(({data}) => {
          this.clientsRates = data
        })
        .catch(err => {
          console.log('Error fetchClientsRates ', err)
        })
    },

    fetchNotis () {
      axios.get('configs/3/items')
        .then(({data}) => {
          this.notis = data
        })
        .catch(err => {
          console.log('Error fetchNotis ', err)
        })
    },

    updateAcc () {
      axios.put('configs/2', {item: this.newAcc})
      .then(({data}) => {
        console.log(data)
      })
      .catch(err => {
        console.log('Error updateAcc ', err)
      })
    },

    updateClientsRate () {
      axios.put('configs/1',{item: this.newClientsRate})
        .then(({data}) => {
          console.log(data)
        })
        .catch(err => {
          console.log('Error updateClientsRate ', err)
        })
    },

    updateNoti () {
      axios.put('configs/3', {item: this.newNoti})
        .then(({data}) => {
          console.log(data)
        })
        .catch(err => {
          console.log('Error updateNotis ', err)
        })
    }
  },

  created () {
    this.fetchConfigs()
    this.fetchAccs()
    this.fetchClientsRates()
    this.fetchNotis()
  }
}
</script>

<style lang="css">
</style>
