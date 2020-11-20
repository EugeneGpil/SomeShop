<template>
    <div>
        <div class='show-field'>
            <div class='show-field__name'>{{ $t('user.name') }}:</div>
            <input
                v-if="mayUpdate()"
                v-model='user.name'
            >
            <div v-else class='show-field__value'>{{ user.name }}</div>
        </div>
        <div class='show-field'>
            <div class='show-field__name'>{{ $t('user.email') }}:</div>
            <input
                v-if="mayUpdate()"
                v-model='user.email'
            >
            <div v-else class='show-field__value'>{{ user.email }}</div>
        </div>
        <div class='show-field'>
            <div class='show-field__name'>{{ $t('user.address') }}:</div>
            <input
                v-if="mayUpdate()"
                v-model='user.address'
            >
            <div v-else class='show-field__value'>{{ user.address }}</div>
        </div>
        <div
            v-if="mayUpdate()"
            class='button'
            @click='updateUser()'
        >{{ $t('user.save_user') }}</div>
    </div>
</template>

<script>
import { updateUser } from '../params/requests.js';

export default {
    name: 'user',
    props: [
        'user'
    ],
    methods: {
        isItMe() {
            return this.user.id == this.me.id;
        },
        updateUser() {
            console.log({update: [this.user]});
            axios[updateUser.method](
                updateUser.url,
                {update: [this.user]}
            ).then(response => {
                //popup
            });
            // }).catch(response => {
            //     this.$store.dispatch('goToMain');
            // });
        },
        mayUpdate() {
            return this.$route.name == 'user' && (this.isItMe() || this.checkRole('admin'))
        }
    },
    computed: {
        checkRole() {
            return this.$store.getters.checkRole;
        },
        me() {
            return this.$store.getters.me;
        }
    }
}
</script>