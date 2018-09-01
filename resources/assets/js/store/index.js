import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        globals: {
            queue: null,
            cashiers: null,
            finished: null,
            avg: null,
            acc: {
                name: null
            },
            clientsRate: {
                name: null
            }
        },
        agencies: []
    },

    actions: {

    },

    mutations: {
        UPDATE_GLOBALS (state, data) {
          state.globals = data
        },

        UPDATE_AGENCY (state, data) {
          state.agencies.forEach((agency, pos) => {
            if (agency.id === data.id) {
              state.agencies[pos] = data
            }
          })
        },

        SET_AGENCIES (state, data) {
          state.agencies = data
        }
    }
})
