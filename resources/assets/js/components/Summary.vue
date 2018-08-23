<template lang="html">
  <div class="" style="font-size:20px;">
      <h3>Conteo Global</h3>
      <br />
      <span>Total fila: <strong>{{ globals.queue }}</strong></span>
      <br />
      <span>Total Cajeros: <strong>{{ globals.cashiers }}</strong></span>
      <br />
      <span>Atendidos hoy: <strong>{{ globals.finished }}</strong></span>
      <br />
      <span>Promedio de espera: <strong>{{ globals.avg }} seg.</strong></span>
  </div>
</template>

<script>
export default {
    props: [
        'globals'
    ]
}
</script>

<style lang="css">
</style>
