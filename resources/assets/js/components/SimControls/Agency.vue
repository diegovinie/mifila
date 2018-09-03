<template lang="html">
  <div :key="agency.id" class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">
        <a
          :href="`#ag_${agency.id}`"
          data-toggle="collapse"
          data-parent="#accordion"
          >
          {{ agency.name }}
          <span class="label label-default">
            {{ agency.info.queue }} en cola
          </span>
        </a>
      </h3>
    </div>
    <div
      class="panel-body panel-collapse collapse"
      :id="`ag_${agency.id}`"
      >
      <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a :href="`#status_${agency.id}`"  data-toggle="tab">Estatus</a>
        </li>
        <li role="presentation">
            <a :href="`#cashiers_${agency.id}`"  data-toggle="tab">Cajas</a>
        </li>
        <li>
          <a :href="`#clients_${agency.id}`" data-toggle="tab">Clientes en espera</a>
        </li>
      </ul>
      <div class="tab-content">
          <div class="tab-pane active" :id="`status_${agency.id}`">
            <div v-if="agency.info">
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
                        <span>Tiempo de espera: {{ agency.info.avg | timefrmt }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Atendiendo a: {{ agency.info.lastCalled }}</span>
                    </li>
                </ul>
            </div>
          </div>
          <div class="tab-pane" :id="`cashiers_${agency.id}`">
              <ul class="list-group">
                <template v-for="(cashier, n) in agency.cashiers" >
                    <li :key="cashier.id" class="list-group-item">
                      <Cashier :num="n + 1" :cashier="cashier"/>
                    </li>
                </template>
              </ul>
              <button
                type="button"
                @click="genCashier()"
                class="btn btn-primary"
                name="button"
                >
                Nuevo
              </button>
          </div>
          <div class="tab-pane" :id="`clients_${agency.id}`">
            <ul class="list-group">
              <template v-for="ticket in agency.info.queuedClientsList" >
                <li :key="ticket.id" class="list-group-item">
                  {{ ticket.client.name }}
                  <span :class="['label', ticket.noti ? 'label-danger' : 'label-info']">
                    {{ ticket.num }}
                  </span>
                </li>
              </template>
            </ul>
            <PickTicket :agency="agency" />
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import Cashier from './Cashier'
import PickTicket from '../PickTicket'

export default {
  props: ['agency'],

  components: {
    PickTicket,
    Cashier
  },

  methods: {
    genCashier () {
      axios.get(`agencies/${this.agency.id}/cashiers/generate`)
        .then(({data}) => {
          console.log(data)
        })
        .catch(err => {
          console.log('Error genCashier ', err)
        })
    }
  }
}
</script>

<style lang="css">
</style>
