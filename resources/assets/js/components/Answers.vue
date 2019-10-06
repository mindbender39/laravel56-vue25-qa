<template>
    <div class="row mt-4" v-cloak v-if="answersCount">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{title}}</h2>
                    </div>
                    <hr>

                    <answer v-for="answer in answers" :answer-model="answer" :key="answer.id"></answer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Answer from './Answer.vue';

    export default {
        name: "Answers",

        props: ['answers', 'answersCount'],

        computed: {
            title() {
                return this.answersCount + ' ' + (this.answersCount > 0 ? 'Answers' : 'Answer');
            }
        },

        components: {
            Answer
        }
    }
</script>
