<template>
  <div class="panel panel-primary">
      <div class="panel-heading">
          <h3 class="panel-title">{{ agency.name }}</h3>
      </div>
      <div class="panel-body">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a :href="`#status_${agency.id}`"  data-toggle="tab">Estatus</a>
            </li>
            <li role="presentation">
                <a :href="`#cashiers_${agency.id}`"  data-toggle="tab">Cajas</a>
            </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane active" :id="`status_${agency.id}`">
                  cola: {{ agency.info.queue }}
                  <br />
                  finalizados: {{ agency.info.finished }}
                  <br/>
                  Atendiendo a: {{ agency.info.lastCalled }}    
              </div>
              <div class="tab-pane" :id="`cashiers_${agency.id}`">
                  <ul>
                    <template v-for="cashier in agency.cashiers" >
                        <li :key="cashier.id">
                            Nombre: {{ cashier.name }}
                        </li>
                    </template>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</template>


<script>
export default {
  props: ['agency']
}
</script>
