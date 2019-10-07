<template>
    <div class="media media-item">
        <vote model-name="answer" :model="answerModel"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="onCancel">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('canModify', answerModel)" @click.prevent="onEdit" class="btn btn-outline-info btn-sm">Edit</a>
                            <button v-if="authorize('canModify', answerModel)" class="btn btn-sm btn-outline-danger" @click="destroy">
                                Delete
                            </button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answerModel" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserInfo from './UserInfo.vue';
    import Vote from './Vote.vue';
    import common from '../mixins/question-answer-common';

    export default {
        name: 'Answer',

        props: ['answerModel'],

        mixins: [common],

        data() {
            return {
                body: this.answerModel.body,
                bodyHtml: this.answerModel.body_html,
                id: this.answerModel.id,
                questionId: this.answerModel.question_id,
                tempBody: null
            }
        },

        components: {
            UserInfo,
            Vote
        },

        methods: {
            setEditCache() {
                this.tempBody = this.body;
            },
            restoreFromCache() {
                this.body = this.tempBody;
            },
            payload() {
                return {
                    body: this.body
                };
            },
            onDelete() {
                axios.delete(this.endpoint)
                    .then(res => {
                        // temporary solution
                        /*$(this.$el).fadeOut(500, () => {
                            this.$toast.success(res.data.message, 'Success!', {timeout:5000});
                        });*/
                        // custom event call to pass data back to parent component
                        // in this case its answers component so child component answer
                        // will delete immediately
                        this.$emit('deleted');
                        this.$toast.success(res.data.message, 'Success!', {timeout:5000});
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                    });
            },
        },

        computed: {
            isInvalid() {
                return this.body.length < 10;
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        }
    }
</script>
