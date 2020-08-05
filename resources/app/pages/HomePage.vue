<template>
    <div>
        <div class="border border-blue-300 rounded-md bg-blue-200 box-shadow-xl p-3">
            <h1 class="font-bold text-lg mb-2">{{user.name}}</h1>
            <div>
                Erfahrung: {{profile.xp}}
            </div>
            <div>
                Level: {{profile.level}}
            </div>

            <div class="border-t border-blue-100 my-2"></div>

            <div>
                <div class="text-sm mb-2">
                        <span class="font-bold">
                            Nächste Stufe
                        </span>
                </div>
                <div class="relative h-5"
                >
                    <div class="absolute top-0 left-0 w-full bg-yellow-200 h-full rounded-md"></div>
                    <div class="absolute top-0 left-0 h-full rounded-md bg-yellow-400"
                         :style="{ width: 30 + '%' }"></div>
                    <div class="absolute top-0 left-0 h-full w-full bg-transparent flex justify-center items-center">
                        {{profile.current_level_xp}}/{{profile.next_level_xp}}
                    </div>
                </div>
            </div>

        </div>


        <div class="border border-blue-300 rounded-md bg-blue-200 box-shadow-xl p-3 mt-8">
            <h1 class="font-bold text-lg mb-2">Neues Spiel</h1>

            <div>
                <h2 class="font-bold mb-1">Regionen</h2>
                <div class="grid grid-cols-2">
                    <label v-for="region in meta.regions">
                        <input type="checkbox" v-model="regions" :value="region.id">
                        {{region.name}}
                    </label>
                </div>

            </div>

            <div class="mt-3" v-if="regions.length > 0">
                <v-button class="w-full flex justify-center" color="green" @click="startGame">Los geht's</v-button>
            </div>
        </div>


    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import axios from 'axios';

    export default {

        props: {},

        data() {
            return {
                regions: ['Africa', 'Americas', 'Asia', 'Europe']
            }
        },

        components: {},

        computed: {

            ...mapGetters(['user', 'profile', 'meta'])

        },

        methods: {

            startGame() {
                axios.put(route('game:start').url(), {regions: this.regions}).then(() => {
                    console.log('check');
                })
            }

        },
    }
</script>

<style lang="scss" scoped>

</style>
