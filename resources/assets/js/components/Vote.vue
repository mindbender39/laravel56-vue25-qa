<template>
    <div class="d-flex flex-column vote-controls">
        <a class="vote-up" :class="classes" :title="setTitle('up')" @click.prevent="voteUp">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{votesCount}}</span>

        <a class="vote-down" :class="classes" :title="setTitle('down')" @click.prevent="voteDown">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="modelName === 'question'" :question-model="model"></favorite>
        <answer-accept v-else-if="modelName === 'answer'" :answer-model="model"></answer-accept>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import AnswerAccept from './AnswerAccept.vue';

    export default {
        name: "Vote",
        props: ['modelName', 'model'],

        data() {
            return {
                votesCount: this.model.votes_count,
                id: this.model.id
            };
        },

        computed: {
            classes() {
                return this.signedId ? '' : 'off';
            },
            endpoint() {
                return `/${this.modelName}s/${this.id}/vote`;
            }
        },

        methods: {
            setTitle(voteType) {
                let titles = {
                    up: `This ${this.modelName} is useful`,
                    down: `This ${this.modelName} is not useful`
                };

                return titles[voteType];
            },
            voteUp() {
                this._vote(1);
            },
            voteDown() {
                this._vote(-1);
            },
            _vote(vote) {
                // signedId is define in: \js\auth\authorize.js
                if (!this.signedId) {
                    this.$toast.warning(`Please login to vote this ${this.modelName}`, 'Warning!', {
                        timeout: 5000,
                        position: 'topLeft'
                    });
                    return;
                }

                axios.post(this.endpoint, {vote})
                    .then(res => {
                        this.$toast.success(res.data.message, 'Success!', {timeout:5000});

                        this.votesCount = res.data.votesCount;
                    })
                    .catch(error => {
                        this.$toast.error(error.data.response.message, 'Error!', {timeout:5000});
                    });
            }
        },

        components: {
            Favorite,
            AnswerAccept
        }
    }
</script>
