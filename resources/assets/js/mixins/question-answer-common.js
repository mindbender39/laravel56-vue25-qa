/*
* Mixins are a flexible way to distribute reusable functionalities for Vue components.
* A mixin object can contain any component options. When a component uses a mixin,
* all options in the mixin will be “mixed” into the component’s own options.
* */
export default {
    data() {
        return {
            editing: false,
        };
    },

    methods: {
        onEdit() {
            this.setEditCache();
            this.editing = true;
        },
        onCancel() {
            this.restoreFromCache();
            this.editing = false;
        },
        setEditCache() {},
        restoreFromCache() {},
        update() {
            axios.put(this.endpoint, this.payload())
                .then(res => {
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    this.$toast.success(res.data.message, 'Success!', {timeout:5000});
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message, 'Error!', {timeout:5000});
                });
        },
        payload() {},
        destroy() {
            this.$toast.question('Are you sure about that?', 'Confirm!', {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                        this.onDelete();

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }],
                ]
            });
        },
        onDelete() {}
    }
}
