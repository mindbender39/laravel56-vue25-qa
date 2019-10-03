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
                        this.bodyHtml = res.data.body_html
                    })
                    .catch(error => {
                        console.log('Something went wrong: ' + error);
                    });
            },
            deleteAnswer() {
                if(confirm('Are you sure, you want to delete this answer?')) {
                    axios.delete(this.endpoint)
                        .then(res => {
                            $(this.$el).fadeOut(500, () => {
                                alert(res.data.message);
                            });
                        })
                        .catch(error => {
                            console.log('Something went wrong: ' + error);
                        });
                }
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
