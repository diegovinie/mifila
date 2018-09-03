import store from '../store'

window.Echo.channel('admin')
    .listen('UpdateGlobals', (e) => {
        // console.log(e.globals)
        store.commit('UPDATE_GLOBALS', e.globals)
    })
    .listen('UpdateAgency', (e) => {
        store.commit('UPDATE_AGENCY', e.agency)
    })
