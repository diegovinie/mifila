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
            agencies: [],
            acc: {
                name: null
            },
            clientsRate: {
                name: null
            }
        }
    },

    actions: {

    },

    mutations: {
        UPDATE_GLOBALS (state, data) {
            state.globals = data
        }
    }
})
