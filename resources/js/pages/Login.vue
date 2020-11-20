<template>
    <div class='form-page-wrapper'>
        <div class='form-container'>
            <input
                class='form-container__input'
                v-model='login'
                :placeholder='$t("login.login")'
                ref='login'
                v-on:keyup.enter='setFocusOnPasswordInput()'
            >
            <input
                class='form-container__input'
                v-model='password'
                :placeholder='$t("login.password")'
                type='password'
                ref='password'
                v-on:keyup.enter='tryToLogin()'
            >
            <div class='form-container__error'>
                <div v-if='loginError'>
                    {{ $t('login.wrong_login_or_password') }}
                </div>
            </div>
            <div class='button' @click='tryToLogin()'>{{ $t('login.enter') }}</div>
        </div>
    </div>
</template>

<script>
import { login } from '../params/requests.js';

export default {
    name: 'login',
    data() {
        return {
            login: '',
            password: '',
            loginError: false
        };
    },
    created() {
        setTimeout(() => {
            this.$nextTick(() => this.setFocus('login'));
        }, 1000);
    },
    methods: {
        setFocusOnPasswordInput() {
            this.setFocus('password');
        },
        setFocus(ref) {
            setTimeout(() => {
                this.$refs[ref].focus();
            }, 200);
        },
        tryToLogin: function() {
            axios[login.method](login.url, {
                email: this.login,
                password: this.password
            }).then(() => {
                this.loginError = false;
                this.$store.dispatch("getMe");
                this.$router.go(-1);
            }).catch(() => {
                this.loginError = true;
            })
        }
    }
}
</script>