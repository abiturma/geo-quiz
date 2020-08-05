<template>
    <div class="h-full p-5 bg-blue-100">
        <div class="max-container">
            <div class="flex justify-end mb-5">
                <form :action="logout" method="post">
                    <input type="hidden" :value="token()" name="_token">
                    <v-button @click="logout" size="sm">Logout</v-button>
                </form>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {

        props: {},

        data() {
            return {}
        },

        components: {},

        computed: {

            logout() {
                return route('logout')
            }

        },

        methods: {
            token() {
                return document.querySelector('meta[name="_token"]').content
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
