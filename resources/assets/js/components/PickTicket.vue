<template lang="html">
  <div class="">
      <div v-if="active">
          <div v-show="!form.active && !ticket.active">
              Nro. Documento:
              <input
                type="text"
                class="form-control"
                name="doc"
                v-model="doc" />
              <br />
              <button
                type="button"
                class="btn btn-info"
                @click="getIdentity()"
                name="button">
                  Enviar
              </button>
              <button
                type="button"
                class="btn btn-default"
                @click="active = false"
                name="button">
                  Regresar
              </button>
          </div>
          <form
            v-show="form.active"
            class=""
            @submit.prevent="createTicket()"
            method="post">
              Documento:
              <input
                type="text"
                class="form-control"
                name="cc"
                v-model="form.data.cc"
                :readonly="!form.editable"/>
              <br />
              Nombre:
              <input
                type="text"
                class="form-control"
                name="name"
                v-model="form.data.name"
                :readonly="!form.editable"/>
              <br />
              Género
              <select
                class="form-control"
                name="gender"
                v-model="form.data.gender"
                :readonly="!form.editable">
                  <option value="male">Masculino</option>
                  <option value="female">Femenino</option>
              </select>
              <br />
              Celular:
              <input
                type="text"
                class="form-control"
                name="phone"
                v-model="form.data.phone"
                :readonly="!form.editable"/>
              <br />
              Atención Preferencial
              <input
                type="checkbox"
                class="form-control"
                name="priority"
                v-model="form.data.priority"
                :readonly="!form.editable"/>
              <br />
              <button
                type="submit"
                class="btn btn-primary"
                name="button">
                  Pedir Turno
              </button>
              <button
                @click="resetForm()"
                type="button"
                class="btn btn-default"
                name="button">
                  Regresar
              </button>

          </form>
          <Ticket
            :ticket="ticket"
            @closeTicket="shutDown()"
            v-if="ticket.active" />
      </div>
      <div v-else>
          <button
            @click="active = true"
            type="button"
            class="btn btn-primary"
            name="button">
            Pedir Turno
          </button>
      </div>
  </div>
</template>

<script>
import Ticket from './Ticket'

export default {
    data: () => ({
        active: false,
        doc: null,
        form: {
            active: false,
            editable: true,
            data: {
                cc: null,
                name: null,
                gender: null,
                phone: null,
                priority: null
            }
        },
        ticket: {
            active: false,
            num: null,
            agency: null,
            name: null
        }
    }),

    props: [
        'agency'
    ],

    components: {
        Ticket
    },

    methods: {
        getIdentity () {
            axios.get('clients/' + this.doc)
                .then(({data, status}) => {
                    if (status === 204) {
                        this.form.data.cc = this.doc
                        this.form.editable = true
                        this.form.active = true
                    } else {
                        this.form.data = data
                        this.form.editable = false
                        this.checkTicket()
                    }
                })
                .catch(err => {
                    console.log('Error getIdentity: ', err)
                })
        },

        checkTicket () {
            axios.get(`clients/${this.doc}/check`)
                .then(({data, status}) => {
                    if (status === 204) {
                        this.form.active = true
                    } else {
                        console.log(data)
                        this.setTicketValues(data)
                        this.ticket.active = true
                    }
                })
                .catch(err => {
                    console.log('Error checkTicket: ', err)
                })
        },

        setTicketValues (data) {
            this.ticket.name = data.client.name
            this.ticket.num = data.num
            this.ticket.agency = data.agency.name
        },

        createTicket () {
            axios.post(`agencies/${this.agency.id}/tickets/create`, this.form.data)
            .then(({data}) => {
                console.log(data)
                this.setTicketValues(data)
                this.ticket.active = true

                this.resetForm()
            })
            .catch(err => {
                console.log('Error createTicket ', err)
            })
        },

        resetForm () {
            this.form = {
                active: false,
                editable: true,
                data: {
                    cc: null,
                    name: null,
                    gender: null,
                    phone: null,
                    priority: null
                }
            }
            this.doc = null
        },

        shutDown () {
            this.ticket.active = false
            this.active = false
        }
    }
}
</script>

<style lang="css">
</style>
