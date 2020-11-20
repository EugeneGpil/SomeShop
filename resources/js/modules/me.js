import { me as meRequest, logout} from '../params/requests.js';
import store from '../store.js';
import router from '../routes.js';

export const me = {
    state: {
        me: {},
        checkRole: (requiredRoles) => {
            let me = store.getters.me;

            if (!me) {
                return false;
            }

            if (store.getters.isObjectEmpty(me)) {
                return false;
            }

            let myRoles = me.roles;

            if (!myRoles) {
                return false;
            }

            if (typeof(requiredRoles) == 'string') {
                requiredRoles = [requiredRoles];
            }

            for (let i = 0; i < myRoles.length; i++) {

                for (let j = 0; j < requiredRoles.length; j++) {

                    if (myRoles[i].name == requiredRoles[j]) {

                        return true;
                    }
                }
            }

            return false;
        }
    },
    mutations: {
        setMe(state, user) {
            state.me = user;
        },
        forgetMe(state) {
            state.me = {};
        }
    },
    actions: {
        getMe(context) {
            axios[meRequest.method](
                meRequest.url
            ).then(resp => {
                context.dispatch('setMe', resp.data);
            }).catch(resp => {
                context.dispatch('logout');
            });
        },
        setMe(context, user) {
            context.commit('setMe', user);
            if (router.currentRoute.name == 'login') {
                try{
                    router.push(-1);
                } catch {
                    router.push({name: 'market'});
                }
            }
        },
        forgetMe(context) {
            context.commit('forgetMe');
        },
        logout(context) {
            axios[logout.method](logout.url).then(resp => {
                context.dispatch("forgetMeAndGoToMain");
            }).catch(resp => {
                context.dispatch("forgetMeAndGoToMain");
            });
        },
        forgetMeAndGoToMain(context) {
            context.commit('forgetMe');
            if (router.history.current.name != 'market') {
                router.push({name: 'market'});
            }   
        },
        goToMain(context) {
            if (router.history.current.name != 'market') {
                router.push({name: 'market'});
            }
        }
    },
    getters: {
        me(state) {
            return state.me;
        },
        checkRole(state) {
            return state.checkRole;
        }
    }
}