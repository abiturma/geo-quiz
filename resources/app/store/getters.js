//


export default {

    //


    user(state) {
        return state.user || {}
    },

    profile(state,getters) {
        return getters.user.profile || {}
    },

    meta(state) {
        return state.meta
    }

}
