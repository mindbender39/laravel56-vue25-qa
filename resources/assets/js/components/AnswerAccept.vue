<template>
    <div>
        <a v-if="canAccept" :class="classes" title="Mark this answer as best answer"
           @click.prevent="saveBestAnswer">
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-if="accepted" :class="classes" title="The question owner accepted this answer as best answer">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "AnswerAccept",
        props: ['answerModel'],

        data() {
            return {
                isBestAnswer: this.answerModel.is_best_answer,
                id: this.answerModel.id
            };
        },

        methods: {
            saveBestAnswer() {
                axios.post(`/answers/${this.id}/accept`)
                    .then(res => {
                        this.$toast.success(res.data.message, 'Success!', {timeout:5000});

                        this.isBestAnswer = true;
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                    });
            }
        },

        computed: {
            canAccept() {
                return this.authorize('accept', this.answerModel);
            },
            accepted() {
                return !this.canAccept && this.isBestAnswer;
            },
            classes() {
                return [
                    'mt-2',
                    this.isBestAnswer ? 'vote-accepted' : ''
                ];
            }
        }
    }
</script>
