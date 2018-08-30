<template lang="html">
  <div class="">
      <div v-if="active">
          <div v-show="!form.active && !ticket.active">
              Nro. Documento: 
              <input type="text" name="doc" v-model="doc" />
              <br />
              <button
                type="button"
                @click="getIdentity()"
                name="button">
                  Enviar
              </button>
              <button
                type="button"
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
                name="cc"
                v-model="form.data.cc"
                :readonly="!form.editable"/>
              <br />
              Nombre:
              <input
                type="text"
                name="name"
                v-model="form.data.name"
                :readonly="!form.editable"/>
              <br />
              Género
              <select
                class=""
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
                name="phone"
                v-model="form.data.phone"
                :readonly="!form.editable"/>
              <br />
              Atención Preferencial
              <input
                type="checkbox"
                name="priority"
                v-model="form.data.priority"
                :readonly="!form.editable"/>
              <br />
              <button
                type="submit"
                name="button">
                  Pedir Turno
              </button>
              <button
                @click="resetForm()"
                type="button"
                name="button">
                  Regresar
              </button>

          </form>
          <div v-if="ticket.active">
              <span>{{ ticket.name }}</span>
              <br />
              <span>Su ticket es: {{ ticket.num }}</span>
              <br />
              <span>En la agencia: {{ ticket.agency }}</span>
              <br />
              <button
                type="button"
                name="button"
                @click="shuwDown()">Aceptar</button>
          </div>
      </div>
      <div v-else>
          <button @click="active = true" type="button" name="button">Pedir Turno</button>
      </div>
  </div>
</template>

<script>
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

    methods: {
        getIdentity () {
            axios.get('clients/' + this.doc)
                .then(({data, status}) => {
                    if (status === 204) {
                        this.form.data.cc = this.doc
                        this.form.editable = true
                    } else {
                        this.form.data = data
                        this.form.editable = false
                    }
                    this.form.active = true
                })
                .catch(err => {
                    console.log('Error getIdentity: ', err)
                })
        },

        createTicket () {
            axios.post(`agencies/${this.agency.id}/tickets/create`, this.form.data)
            .then(({data}) => {
                console.log(data)
                this.ticket.name = data.client.name
                this.ticket.num = data.num
                this.ticket.agency = data.agency.name
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

        shuwDown () {
            this.ticket = false
            this.active = false
        }
    }
}
</script>

<style lang="css">
</style>
