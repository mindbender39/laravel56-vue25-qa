<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="7" required v-model="body"
                                      minlength="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                            <span class="text-danger ml-3" :style="{display: (isInvalid?'':'none')}">
                                Write your answer minimum 10 characters long.
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewAnswer",

        props: ['questionId'],

        data() {
            return {
                body: ''
            };
        },

        computed: {
            isInvalid() {
                return !this.signedId || this.body.length < 10;
            }
        },

        methods: {
            create() {
                axios.post(`/questions/${this.questionId}/answers`, {
                    body: this.body
                })
                    .then(({data}) => {
                        this.$toast.success(data.message, 'Success!', {timeout: 5000});
                        this.body = '';

                        this.$emit('created', data.answer);
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error', {timeout: 5000});
                    });
            }
        }
    }
</script>
