import policies from './policies';

export default {
    // this will work as a plugin
    install(Vue, options) {
        // prototype is a way to inherit a class and by doing this we can access authorize() in
        // our components.
        Vue.prototype.authorize = (policy, model) => {
            if (!window.Auth.signedId) return false;

            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;

                return policies[policy](user, model);
            }
        };

        Vue.prototype.signedId = window.Auth.signedId;
    }
}
