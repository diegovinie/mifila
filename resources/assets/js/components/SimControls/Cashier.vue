<template lang="html">
  <div class="">
    Caja {{ cashier.id }}
    <br />
    Nombre: {{ cashier.name }}
    <br />
    Promedio: {{ cashier.rate}} s
    <br />
    <div class="checkbox">
      <label>
        <input
        type="checkbox"
        name=""
        v-model="cashier.active" />
        Activo
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: ['cashier']
}
</script>

<style lang="css">
</style>
