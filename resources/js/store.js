import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import { global } from './modules/global.js';
import { order } from './modules/order.js';
import { me } from './modules/me.js';
import { userlist } from './modules/userlist.js';

export default new Vuex.Store({
	modules: {
        global,
        order,
        me,
        userlist
    }
});
