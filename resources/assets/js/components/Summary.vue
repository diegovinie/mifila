<template lang="html">
  <div class="" style="font-size:20px;">
      <span>Total fila: <strong>{{ globals.queue }}</strong> </span>
      <br />
      <span>Total Cajeros: <strong>{{ globals.cashiers }}</strong> </span>
      <br />
      <span>Atendidos hoy: <strong>{{ globals.finished }}</strong> </span>
      <br />
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
