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
              <InputTicket
                @typing="changeInput"
                name="cc"
                type="text"
                :value="form.data.cc"
                label="Documento:"
                :editable="form.editable"
                :errors="errors" />

              <InputTicket
                @typing="changeInput"
                name="name"
                type="text"
                :value="form.data.name"
                label="Nombre:"
                :editable="form.editable"
                :errors="errors" />

              <div class="form-inline row">
                <label>Género:
                  <select
                    class="form-control"
                    name="gender"
                    v-model="form.data.gender"
                    :readonly="!form.editable">
                    <option value="male">Masculino</option>
                    <option value="female">Femenino</option>
                  </select>
                </label>
                <div class="checkbox col-xs-6">
                  <label><input
                    type="checkbox"
                    name="priority"
                    v-model="form.data.priority"
                    :readonly="!form.editable"/>
                    Atención Preferencial
                  </label>
                </div>
                <div class="checkbox col-xs-6">
                  <label><input
                    type="checkbox"
                    name="notifiable"
                    v-model="form.data.notifiable"
                    />
                    Notificar:
                  </label>
                </div>
              </div>
              <InputTicket
                @typing="changeInput"
                name="phone"
                type="text"
                :value="form.data.phone"
                label="Celular:"
                :editable="form.editable"
                :errors="errors" />

              <InputTicket
                @typing="changeInput"
                name="email"
                type="text"
                :value="form.data.email"
                label="Correo:"
                :editable="form.editable"
                :errors="errors" />

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
import InputTicket from './InputTicket'

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
                priority: null,
                notifiable: true
            }
        },
        ticket: {
            active: false,
            num: null,
            agency: null,
            name: null
        },
        errors: {}
    }),

    props: [
        'agency'
    ],

    components: {
        Ticket,
        InputTicket
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
                        this.form.data.notifiable = true
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
            this.errors = {}

            axios.post(`agencies/${this.agency.id}/tickets/create`, this.form.data)
            .then(({data, status}) => {
                if (status === 422) {
                    console.log(data)
                }
                console.log(data)
                this.setTicketValues(data)
                this.ticket.active = true

                this.resetForm()
            })
            .catch(err => {
              if (err.response.status === 422) {
                this.errors = err.response.data.errors
              } else {
                console.log('Error createTicket ', err)
              }
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
                    priority: null,
                    notifiable: true
                }
            }
            this.doc = null
            this.errors = {}
        },

        shutDown () {
            this.ticket.active = false
            this.active = false
            this.resetForm()
        },

        changeInput (name, value) {
          this.form.data[name] = value
        }
    }
}
</script>

<style lang="css">
</style>
