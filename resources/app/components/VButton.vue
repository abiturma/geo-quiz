<template>
    <button class="flex items-center font-bold focus:outline-none"
            :class="[colorClass,sizeClass,generalClass]"
            @click="$emit('click')"
    >
        <div>
            <slot/> <template v-if="loading">...lädt...</template>
        </div>
    </button>
</template>

<script>
    export default {

        props: {

            color: {
                type: String,
                default: 'default',
                validator(color) {
                    return ['green', 'default', 'grey', 'blue'].includes(color)
                }
            },

            size: {
                type: String,
                validator(size) {
                    return ['md', 'lg', 'sm', 'xs'].includes(size)
                },
                default: 'md'
            },

            loading: {
                type: Boolean,
                default: false
            }

        },

        data() {
            return {}
        },

        components: {},

        computed: {


            colorClass() {
                let map = {
                    green: 'bg-green-500 text-white',
                    default: 'bg-gray-500 text-gray-200',
                    grey: 'bg-gray-800 text-gray-200',
                    blue: 'bg-blue-400 text-blue-800',
                }

           /*     if (this.mode === 'ghost') {
                    map = {
                        green: 'border border-green-400 text-green-900',
                        default: 'border border-white text-white',
                        grey: 'border border-grey-900 text-grey-100',
                    }
                }*/

                return map[this.color]
            },


            generalClass() {
                return {
                    'shadow-lg': true,
                }
            },

            sizeClass() {
                const map = {
                    md: 'px-3 py-2 rounded-md',
                    lg: 'px-5 py-4 rounded-md',
                    sm: 'px-1 py-1 text-sm rounded-md',
                    xs: 'px-1 py-1 text-xs rounded-md'
                }
                return map[this.size];
            }
        },

        methods: {},
    }
</script>

<style lang="scss" scoped>

</style>
