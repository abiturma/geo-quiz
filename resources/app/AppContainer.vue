<template>
        <router-view/>
</template>

<script>


    import { mapMutations } from "vuex";

    export default {

        props: {
            user: {
                type: Object,
                required: true
            },

            meta: {
                type: Object,
                required: true
            }
        },


        methods: {
            ...mapMutations(['setUser','setMeta'])
        },

        created() {
            this.setUser(this.user)
            this.setMeta(this.meta)
        }

    }

</script>

<style lang="scss" scoped>

</style>
