import { me } from '../params/requests.js';

export function initialize(store, router) {

    axios[me.method](me.url).then(resp => {
        store.dispatch('setMe', resp.data)
    }).catch(() => {});
}