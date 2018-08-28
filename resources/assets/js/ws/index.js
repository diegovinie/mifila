import store from '../store'

window.Echo.channel('ticket')
    .listen('UpdateGlobals', (e) => {
        console.log(e.globals)
        store.commit('UPDATE_GLOBALS', e.globals)
    })

// export default Echo