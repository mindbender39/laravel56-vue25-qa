<template>
    <div>
        <a :class="classes" title="Click to mark as favorite question (Click again to undo)"
           @click.prevent="toggleFavorite">
            <i class="fas fa-star fa-2x"></i>
            <span class="favorites-count">{{count}}</span>
        </a>
    </div>
</template>

<script>
    export default {
        name: "Favorite",
        props: ['questionModel'],

        data() {
            return {
                isFavorited: this.questionModel.is_favorited,
                count: this.questionModel.favorites_count,
                id: this.questionModel.id
            }
        },

        computed: {
            classes() {
                return [
                    'favorite', 'mt-2',
                    !this.signedId ? 'off' : (this.isFavorited ? 'favorited' : '')
                ]
            },
            signedId() {
                return window.Auth.signedId;
            },
            endpoint() {
                return `/questions/${this.id}/favorites`;
            }
        },

        methods: {
            toggleFavorite() {
                if (!this.signedId) {
                    this.$toast.warning('Please login to mark this question as favorite.', 'Warning!', {
                        timeout: 5000,
                        position: 'topLeft'
                    });
                    return;
                }

                this.isFavorited ? this.deleteFavorite() : this.addFavorite();
            },
            deleteFavorite() {
                axios.delete(this.endpoint)
                    .then(res => {
                        this.count--;
                        this.isFavorited = false;
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                    });
            },
            addFavorite() {
                axios.post(this.endpoint)
                    .then(res => {
                        this.count++;
                        this.isFavorited = true;
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                    });
            }
        }
    }
</script>
