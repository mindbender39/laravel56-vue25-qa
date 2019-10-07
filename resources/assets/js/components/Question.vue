<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="updateQuestion">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <textarea v-model="body" rows="10" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary" :disabled="isInvalid">Update</button>
                            <button type="button" class="btn btn-outline-secondary" @click="onCancel">Cancel</button>
                        </div>
                    </div>
                </form>

                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{title}}</h1>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">
                                    Back to All Question
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <vote model-name="question" :model="questionModel"></vote>

                        <div class="media-body">
                            <div v-html="bodyHtml"></div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('canModify', questionModel)" @click.prevent="onEdit" class="btn btn-outline-info btn-sm">Edit</a>
                                        <button v-if="authorize('deleteQuestion', questionModel)" class="btn btn-sm btn-outline-danger" @click="deleteQuestion">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info :model="questionModel" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
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
        name: "Question",

        props: ['questionModel'],

        data() {
            return {
                title: this.questionModel.title,
                body: this.questionModel.body,
                bodyHtml: this.questionModel.body_html,
                editing: false,
                id: this.questionModel.id,
                beforeEditCache: {}
            };
        },

        components: {
            UserInfo,
            Vote
        },

        computed: {
            isInvalid() {
                return this.body.length < 10 || this.title.length < 10;
            },
            endpoint() {
                return `/questions/${this.id}`;
            }
        },

        methods: {
            onEdit() {
                this.beforeEditCache = {
                    title: this.title,
                    body: this.body
                };

                this.editing = true;
            },
            onCancel() {
                this.body = this.beforeEditCache.body;
                this.title = this.beforeEditCache.title;
                this.editing = false;
            },
            updateQuestion() {
                axios.put(this.endpoint, {
                    body: this.body,
                    title: this.title
                })
                    .then(({data}) => {
                        this.bodyHtml = data.body_html;
                        this.$toast.success(data.message, 'Success!', {timeout:5000});
                        this.editing = false;
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.methods, 'Error!', {timeout:5000});
                    });
            },
            deleteQuestion() {
                this.$toast.question('Are you sure, you want to delete this question?', 'Confirm!', {
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
                                .then(({data}) => {
                                    this.$toast.success(data.message, 'Success!', {timeout:3000});
                                })
                                .catch(error => {
                                    this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                                });

                            setTimeout(() => {
                                window.location.href = '/questions'
                            }, 3000);

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ]
                });
            }
        }
    }
</script>
