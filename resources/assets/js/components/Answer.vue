<!-- _answer.blade.php file will work as an inline-template for this component -->
<script>
    export default {
        name: 'answer-cmp',

        props: ['answer'],

        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                tempBody: null
            }
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
                        this.$toast.success(res.data.message, 'Success!', {timeout:3000});
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:3000});
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
                                    $(this.$el).fadeOut(500, () => {
                                        this.$toast.success(res.data.message, 'Success!', {timeout:3000});
                                    });
                                })
                                .catch(error => {
                                    this.$toast.error(error.response.data.message, 'Error!', {timeout:3000});
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
