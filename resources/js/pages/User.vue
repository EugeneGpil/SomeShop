<template>
    <div class='page-wrapper'>
        <user :user='user' />
        <div class='block-headline'>
            {{ $t('user.orders') }}
        </div>
        <div class='list'>
            <div v-for='order in orders' :key='order.id' class='list-item'>
                <router-link
                    v-if="checkRole('admin') || isItMe() && !order.deleted"
                    class='link list-item' :to="{name: 'order', params: {id: order.id}}"
                >
                    <div class='list-item__id'>{{ order.id }}</div>
                    <div class='list-item__cell'>{{ order.order_status.name }}</div>
                    <div class='list-item__cell'>{{ order.main_product_name }}</div>
                    <div class='list-item__cell'>{{ order.price }}</div>
                </router-link>
                <font-awesome-icon
                    v-if="checkRole('admin') && !order.deleted"
                    @click="updateDeletedOrder(order.id, true)"
                    class='remove-list-item-button'
                    icon='trash-alt'
                />
                <font-awesome-icon
                    v-if="checkRole('admin') && order.deleted"
                    @click="updateDeletedOrder(order.id, false)"
                    class='remove-list-item-button'
                    icon='trash-restore-alt'
                />
            </div>
        </div>
    </div>
</template>

<script>
import VueTable from '../components/VueTable.vue';
import User from '../components/User.vue';
import { getUser, updateOrder } from '../params/requests.js';

export default {
    components: {
        VueTable,
        User
    },
    data() {
        return {
            user: {},
            orders: []
        };
    },
    computed: {
        checkRole() {
            return this.$store.getters.checkRole;
        },
        me() {
            return this.$store.getters.me;
        }
    },
    mounted() {
        let lang = '';
        if (this.$i18n.locale != 'en') {
            lang = `${this.$i18n.locale}`;
        }

        axios[getUser.method](getUser.getUrl({
            id: this.$route.params.id,
            lang
        })).then(response => {
            let resp = response.data;
            this.user = resp;
            this.orders = this.user.orders;

            for (let i = 0; i < this.orders.length; i++) {
                this.orders[i].main_product_name = this.getMainProductName(this.orders[i].products);
                this.orders[i].price = this.getPriceSum(this.orders[i].products);
            }
        }).catch(resp => {
            this.$store.dispatch('goToMain');
        });
    },
    methods: {
        getPriceSum: function(products) {
            let priceSum = 0;
            for (let i = 0; i < products.length; i++) {
                priceSum += products[i].price;
            }
            priceSum = priceSum * 100;
            priceSum = parseInt(priceSum);
            priceSum = priceSum / 100;  
            return priceSum;
        },
        getMainProductName: function(products) {
            let mainProduct = products[0];
            for (let i = 1; i < products.length; i++) {
                if (mainProduct.price < products[i].price) {
                    mainProduct = products[i];
                }
            };
            return mainProduct.name;
        },
        isItMe() {
            return this.user.id == this.me.id;
        },
        updateDeletedOrder(id, deleted) {
            axios[updateOrder.method](
                updateOrder.url,
                {
                    update: [{
                        id,
                        deleted
                    }]
                }
            ).then(response => {
                for (let i = 0; i < this.orders.length; i++) {
                    if (this.orders[i].id == id) {
                        this.orders[i].deleted = deleted;
                        return;
                    }
                }
            }).catch(response => {
                this.$store.dispatch('goToMain');
            });
        }
    }
}
</script>