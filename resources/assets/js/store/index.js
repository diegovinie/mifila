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

        },
        // agency: {
        //     id: null,
        //     name: null,
        //     cashiers: [],
        //     queue: null,
        //     finished: null,
        //     avg: null,
        //     lastCalled: null
        // },
        // cashier: {
        //     id: null,
        //     name: null,
        //     finished: null,
        //     avg: null,
        //     lastCalled: null
        // }
    },

    actions: {
        // NEW_TICKET ({commit}, ticket) {
        //     commit('QUEUE_UP', ticket)
        //     commit('UPDATE_QUEUES')
        //     // cola sube en uno
        //     // sube la cola de la agencia
        //     // sube la cola total
        //
        // },
        //
        // NEW_SERVICE ({commit}, service) {
        //     commit('FINISHED_UP', service)
        //     commit('SET_LAST_CALLED', service)
        //
        //     commit('UPDATE_FINISHED')
        //     commit('UPDATE_LASTS_CALLED')
        //     // cola baja en uno
        //     // baja la cola de la agencia
        //     // baja la cola total
        //     // cajero termina
        //     // agencia termina
        //     // global termina
        //     // numero de ticket
        //     // numero agencia

        // }

    },

    mutations: {
        UPDATE_GLOBALS (state, data) {
            state.globals = data
        }
        // QUEUE_UP (state, data) {
        //     const agency = state.globals.agencies.find(agency => agency.id === data.agency.id)
        //     agency.queue += 1
        // },
        //
        // UPDATE_QUEUES (state) {
        //     const queue = state.globals.agencies.reduce((agency, total) => {
        //         agency.queue = agency.cashiers.reduce((cashier, sum) => {
        //             return total + cashier.queue
        //         })
        //
        //         return total + agency.queue
        //     })
        //
        //     state.globals.queue = queue
        //
        // },
        //
        // QUEUE_DOWN (state, data) {
        //
        // },
        //
        // FINISHED_UP (state, data) {
        //     const cashier = agency.cashiers.find(cashier => cashier.id === data.cashier.id)
        //
        // },
        //
        // UPDATE_FINISHED (state) {
        //
        // },
        //
        // SET_LAST_CALLED (state, data) {
        //
        // },
        //
        // UPDATE_LASTS_CALLED (state) {
        //
        // }
    }
})
