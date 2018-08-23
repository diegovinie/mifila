<template lang="html">
  <div class="panel panel-default" style="font-size:20px;">
      <div class="panel-heading">
          <h3>Conteo Global</h3>
      </div>
      <div class="panel-body">
          <ul class="list-group">
              <li class="list-group-item">
                  <span>Total fila: <strong>{{ globals.queue }}</strong></span>
              </li>
              <li class="list-group-item">
                  <span>Total Cajeros: <strong>{{ globals.cashiers }}</strong></span>
              </li>
              <li class="list-group-item">
                  <span>Atendidos hoy: <strong>{{ globals.finished }}</strong></span>
              </li>
              <li class="list-group-item">
                  <span>Promedio de espera: <strong>{{ globals.avg }} seg.</strong></span>
              </li>
          </ul>
      </div>
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
