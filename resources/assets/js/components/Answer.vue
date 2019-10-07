<template>
    <div class="media media-item">
        <vote model-name="answer" :model="answerModel"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="updateAnswer">
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
                            <button v-if="authorize('canModify', answerModel)" class="btn btn-sm btn-outline-danger" @click="deleteAnswer">
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

    export default {
        name: 'Answer',

        props: ['answerModel'],

        data() {
            return {
                editing: false,
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
            onEdit() {
                this.tempBody = this.body;
                this.editing = true;
            },
            onCancel() {
                this.body = this.tempBody;
                this.editing = false;
            },
            updateAnswer() {
                axios.patch(this.endpoint, {
                    body: this.body
                })
                    .then(res => {
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                        this.$toast.success(res.data.message, 'Success!', {timeout:5000});
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                    });
            },
            deleteAnswer() {
                this.$toast.question('Are you sure, you want to delete this answer?', 'Confirm!', {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
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
                                })
                                .catch(error => {
                                    this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                                });

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ]
                });
            }
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
