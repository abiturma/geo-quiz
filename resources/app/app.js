import Vue from 'vue';
import AppContainer from "@/AppContainer";
import VButton from "@/components/VButton";
import store from "@/store"
import router from "@/router"


Vue.component('v-button',VButton)

new Vue({
    el: '#app',
    store,
    router,
    components: {
        AppContainer
    },
});
