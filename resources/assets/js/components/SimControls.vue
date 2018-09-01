<template>
  <div class="panel panel-info" >
	  <div class="panel-heading">
		  <h3 class="panel-title">Controles Simulador</h3>
	  </div>
	  <div class="panel-body">
      <ul class="nav nav-tabs">
        <li role="presentation" class="active">
          <a href="#globals" data-toggle="tab">Conf. globales</a>
        </li>
        <li role="presentation">
          <a href="#agencies" data-toggle="tab">Agencias</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="globals">
          <div class="checkbox">
              <label>
                <input
                  type="checkbox"
                  readonly
                  v-model="globals.simActive"
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
        </div>
        <div class="tab-pane" id="agencies">
          <div class="panel-group" id="accordion">
            <template v-for="agency in globals.agencies" >
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
                                    <span>Tiempo de espera: {{ agency.info.avg }} seg.</span>
                                </li>
                                <li class="list-group-item">
                                    <span>Atendiendo a: {{ agency.info.lastCalled }}</span>
                                </li>
                            </ul>
                        </div>
                      </div>
                      <div class="tab-pane" :id="`cashiers_${agency.id}`">
                          <ul class="list-group">
                            <template v-for="cashier in agency.cashiers" >
                                <li :key="cashier.id" class="list-group-item">
                                  Caja {{ cashier.id }}
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
                                </li>
                            </template>
                          </ul>
                          <button
                            type="button"
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
                              Doc: {{ ticket.client.cc }} {{ ticket.client.name }}
                              <span class="label label-info">
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
          </div>
        </div>
      </div>
		<br />

		<br />
	  </div>
  </div>
</template>

<script>
import PickTicket from './PickTicket'

export default {
	data: () => ({
		newAcc: null,
		newClientsRate: null,
		accs: [],
		clientsRates: []
	}),

  props: ['globals'],

  components: {
    PickTicket
  },

	methods: {
		fetchConfigs () {
			axios.get('configs')
				.then(({data}) => {
					data.forEach(config => {
						console.log(config.name)
						if (config.name === 'acc') {
							this.newAcc = config.current.id

							// {
							// 	id: config.current.id,
							// 	name: config.current.name,
							// 	description: config.current.description
							// }
						}
						if (config.name === 'clients_rate') {
							this.newClientsRate = config.current.id
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
		}
	},

	created () {
		this.fetchConfigs()
		this.fetchAccs()
		this.fetchClientsRates()
	}
}
</script>
