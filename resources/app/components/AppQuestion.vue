<template>
    <div class="h-full w-full" @click.capture="next">
        <div class="border-blue-300 border shadow-xl rounded-lg bg-blue-200 p-3">
            <h2 class="text-center text-md font-bold mb-3">Wem gehört diese Flagge?</h2>
            <div class="flex justify-center">
                    <img :src="question.flag_path" class="w-32">
            </div>
        </div>
        <hr class="border border-gray-400 my-4"/>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" v-if="!isCompleted">
            <v-button class="w-full justify-center" v-for="option in question.options"
                      :key="option.display"
                      color="blue"
                      @click="evaluate(option)"
            >
                {{option.display}}
            </v-button>
        </div>

        <div class="border border shadow-xl rounded-lg min-h-12 p-3" v-else
             :class="resultColor"
             >
            <div class="flex justify-center font-bold" v-if="isCorrect">
                Das ist richtig!
            </div>
            <div v-else>
                <div>
                    <span class="font-bold">Das ist leider falsch!</span>
                    <span class="text-sm">Richtig wäre gewesen:</span>
                </div>
                <div class="flex justify-center text-lg font-bold mt-2">
                    {{correctAnswer}}
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {

        props: {
            question: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                isCompleted: false,
                isCorrect: false
            }
        },

        components: {},

        computed: {
            resultColor() {
                return this.isCorrect ? 'border-green-300 text-green-700 bg-green-200' : 'border-red-300 text-red-700 bg-red-200'
            },

            correctAnswer() {
                return this.question.options.filter(o => o.is_correct)[0].display
            }
        },

        methods: {
            evaluate(option) {
                this.isCorrect = option.is_correct
                this.isCompleted = true
            },

            next() {
                if(this.isCompleted) {
                    this.$emit('completed',this.isCorrect)
                }
            }
        },

        watch: {
            question() {
                this.isCompleted = false
                this.isCorrect = false
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
