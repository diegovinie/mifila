import Vue from 'vue'

Vue.filter('timefrmt', (sec) => {
    let h, m, s, sr
    sec = parseInt(sec)

    if (sec < 60) {
        return `${sec} sec`
    }

    if (sec < 3600) {
        m = Math.floor(sec / 60)
        s = sec % 60
        return `${m}:${s}`
    }

    h = Math.floor(sec / 3600)
    sr = sec % 3600
    m = Math.floor(sr / 60)
    s = sr % 60

    let minutes = m.toString().replace(/^\d$/, num => `0${num}`)
    let seconds = s.toString().replace(/^\d$/, num => `0${num}`)

    return `${h}:${minutes}:${seconds}`
})

export default Vue
