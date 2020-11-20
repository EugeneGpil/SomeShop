<template>
    <div class='header'>
        <div class='header__logo-container'>
            <router-link :to="{name: 'market'}" class='header__logo'>Medieval trade</router-link>
            <router-link
                :to="{name: 'admin'}"
                class='header__admin-button'
                v-if="checkRole('admin')"
            >
                <font-awesome-icon icon='cog' />
            </router-link>
        </div>
        <div class='header__settings'>
            <div class='header__login-container'>

                <router-link 
                    :to="{name: 'login'}"
                    class='header__login-button button'
                    v-if='isObjectEmpty(me)'
                >{{ $t('main.login' )}}</router-link>

                <router-link 
                    :to="{name: 'registration'}"
                    class='header__login-button button'
                    v-if='isObjectEmpty(me)'
                >{{ $t('main.registration') }}</router-link>

                <div
                    @click='goToProfile()'
                    class='header__login-button button'
                    v-if='!isObjectEmpty(me)'
                >{{ $t('main.profile') }}</div>

                <div
                    class='header__login-button button'
                    v-if='!isObjectEmpty(me)'
                    @click='logout()'
                >{{ $t('main.logout') }}</div>

                <router-link :to="{name: 'basket'}" class='button'>
                    <font-awesome-icon class='button__icon' icon="shopping-basket" />
                </router-link>
            </div>
            <div class='header__language-container'>
                <div class='header__language-button button' @click.prevent='setLocale("en")'>En</div>
                <div class='header__language-button button' @click.prevent='setLocale("ru")'>Ru</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'vue-header',
    methods: {
        setLocale(locale) {
            if (this.$i18n.locale != locale) {
                this.$i18n.locale = locale;
            }
        },
        logout() {
            this.$store.dispatch('logout');
        },
        goToProfile() {
            if (this.$router.history.current.name == 'user') {
                this.$router.push({name: 'market'});
            }
            setTimeout(() => {
                this.$router.push({name: 'user', params: {id: this.me.id}});
            }, 0);
        }
    },
    computed: {
        me() {
            return this.$store.getters.me;
        },
        isObjectEmpty() {
            return this.$store.getters.isObjectEmpty;
        },
        checkRole() {
            return this.$store.getters.checkRole;
        }
    },
}
</script>