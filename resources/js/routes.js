import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store.js';

Vue.use(VueRouter);

export default new VueRouter({
	mode: "history",
	routes: [
		{
			path: '/',
			component: Vue.component('Home', require('./pages/Home.vue')).default,
			children: [
				{
					path: '/',
					name: 'market',
					component: Vue.component('Market', require('./pages/Market.vue')).default,
				},
				{
					path: '/login',
					name: 'login',
					component: Vue.component('Login', require('./pages/Login.vue')).default,
				},
				{
					path: '/registration',
					name: 'registration',
					component: Vue.component('Registration', require('./pages/Registration.vue')).default,
				},
				{
					path: '/basket',
					name: 'basket',
					component: Vue.component('Basket', require('./pages/Basket.vue')).default,
				},
				{
					path: '/product/:id',
					name: 'product',
					component: Vue.component('Product', require('./pages/Product.vue')).default,
				},
				{
					path: '/admin',
					name: 'admin',
					component: Vue.component('Admin', require('./pages/AdminMenu.vue')).default,
				},
				{
					path: '/userlist',
					name: 'userlist',
					component: Vue.component('Userlist', require('./pages/Userlist.vue')).default,
				},
				{
					path: '/user/:id',
					name: 'user',
					component: Vue.component('User', require('./pages/User.vue')).default,
				},
				{
					path: '/order/:id',
					name: 'order',
					component: Vue.component('Product', require('./pages/Order.vue')).default,
					beforeEnter: (to, from, next) => {
						if (from.path != '/add_product_to_order') {
							store.commit("rememberOrder", {});
						}
						next();
					}
				}
			]
		},
		{
			path: '/add_product_to_order',
			name: 'add_product_to_order',
			component: Vue.component('AddProductToOrder', require('./pages/AddProductToOrder.vue')).default
		}
	],
});
