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
                axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                    .then(res => {
                        this.editing = false;
                        this.bodyHtml = res.data.body_html
                    })
                    .catch(error => {
                        console.log('Something went wrong: ' + error);
                    });
            }
        },

        computed: {
            isInvalid() {
                return this.body.length < 10;
            }
        }
    }
</script>
