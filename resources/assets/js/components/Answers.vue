<template>
    <div class="row mt-4" v-cloak v-if="answersCount">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{title}}</h2>
                    </div>
                    <hr>

                    <answer @deleted="removeAnswer(index)" v-for="(answer, index) in answers" :answer-model="answer" :key="answer.id"></answer>

                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Answer from './Answer.vue';

    export default {
        name: "Answers",

        props: ['questionModel'],

        data() {
            return {
                questionId: this.questionModel.id,
                answersCount: this.questionModel.answers_count,
                answers: [],
                nextUrl: null
            };
        },

        // VueJs life cycle function created() makes a call to load answers by ajax
        // as VueJs Answers component created.
        created() {
            this.fetch(`/questions/${this.questionId}/answers`);
        },

        methods: {
            fetch(endpoint) {
                // get data object by using destructuring feature of ES6
                // It's a JavaScript expression that allows us to extract data from arrays,
                // objects, maps and sets.
                axios.get(endpoint)
                    .then(({data}) => {
                        this.answers.push(...data.data);
                        this.nextUrl = data.next_page_url;
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {
                            timeout: 5000
                        });
                    });
            },
            removeAnswer(index) {
                this.answers.splice(index, 1);
                this.answersCount--;
            }
        },

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
