<template lang="html">
  <div class="">
    Caja {{ num }}
    <br />
    Nombre: {{ cashier.name }}
    <br />
    Promedio: {{ cashier.rate}} s
    <br />
    <span v-if="cashier.active">
        Atendiendo a: {{ cashier.current || 'en espera' }}
        <br />
    </span>
    <div class="checkbox">
      <label>
        <input
        type="checkbox"
        @change="swapActive(cashier)"
        name=""
        v-model="cashier.active" />
        Activo
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: ['cashier', 'num'],

  methods: {
      swapActive (cashier) {
          axios.put(`cashiers/${cashier.id}`, {active: cashier.active})
            .then(({data}) => {
                console.log(data)
            })
            .catch(err => {
                console.log('Error en swapActive ', err)
            })
      }
  }
}
</script>

<style lang="css">
</style>
