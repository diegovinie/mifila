<template lang="html">
  <div class="btn-group">
      <button
        type="button"
        class="btn btn-default"
        @click="deletePendingTickets()">
          Limpiar Cola
      </button>
      <button
        type="button"
        class="btn btn-default"
        @click="deleteAllTickets()">
          Eliminar registros
      </button>
  </div>
</template>

<script>
export default {
  props: ['agency'],

  computed: {
      url: function () {
          return this.agency ? `agencies/${this.agency.id}` : 'globals'
      }
  },

  methods: {
    deletePendingTickets () {
      axios.delete(`${this.url}/pending`)
        .then(({data, status}) => {
            this.$emit('reload')
        })
        .catch(err => {
            console.log('Error deletePendingTickets ', err)
        })
    },

    deleteAllTickets () {
      axios.delete(`${this.url}/tickets`)
        .then(({data, status}) => {
            this.$emit('reload')
        })
        .catch(err => {
            console.log('Error deleteAllTickets ', err)
        })
    }
  }
}
</script>

<style lang="css">
</style>
