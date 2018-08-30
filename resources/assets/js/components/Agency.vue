<template lang="html">
  <div class="col-xs-12 col-sm-6 col-lg-4">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h4>{{ agency.name }}</h4>
          </div>
          <div v-if="agency.info" class="panel-body">
              <ul class="list-group">
                  <li class="list-group-item">
                      <span>Cajeros: {{ agency.info.cashiers }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Clientes en espera: {{ agency.info.queue }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Total atendidos: {{ agency.info.finished }}</span>
                  </li>
                  <li class="list-group-item">
                      <span>Tiempo de espera: {{ agency.info.avg }} seg.</span>
                  </li>
                  <li class="list-group-item">
                      <span>Atendiendo a: {{ agency.info.lastCalled }}</span>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    data: () => ({

    }),

    props: [
        'agency'
    ]
}
</script>

<style lang="css">
</style>
