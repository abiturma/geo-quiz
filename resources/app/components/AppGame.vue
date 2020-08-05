<template>
    <div class="max-container py-16 h-full">
        <div class="flex content-center h-full">
            <v-button @click="start" class="w-full justify-center" color="green" v-if="currentIndex < 0">Los geht's</v-button>
            <app-question v-for="question in questions" :question="question" :key="question.id" v-show="hasQuestion && question.id === currentQuestion.id" @completed="nextQuestion"/>
            <div v-if="currentIndex >= questions.length" class="bg-gray-300 border border-gray-100 rounded-lg shadow-xl h-20 p-3 w-full">
                <h2 class="font-bold text-md">
                    Dein Ergebnis:
                </h2>
                {{correctAnswers}} von {{questions.length}} richtig beantwortet!
            </div>
        </div>
    </div>
</template>

<script>
    import AppQuestion from "@/components/AppQuestion";

    export default {

        props: {
            questions: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                currentIndex: 0,
                correctAnswers: 0
            }
        },

        components: {AppQuestion},

        computed: {


            hasQuestion() {
                return this.currentIndex >= 0 && this.currentIndex < this.questions.length
            },

            currentQuestion() {
                return this.questions[this.currentIndex]
            }
        },

        methods: {
            start() {
                this.currentIndex = 1
            },

            nextQuestion(isCorrect) {
                const increment = isCorrect ? 1 : 0
                this.correctAnswers += increment;
                this.currentIndex++
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
