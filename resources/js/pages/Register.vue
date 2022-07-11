<template>
    <div class="text-center">
        <h1>Create your account</h1>

        <div class="screen center " style="margin-top: 5rem" v-if="show">
            <div class="screen__content">
                <form class="login text-center">
                    <!--                    <h3 class="text-danger">{{errors.invalidData}}</h3>-->
                    <div class="login__field">
                        <input type="text" v-model="form.email" class="login__input" placeholder=" Email"
                               id="input-group-1">
                        <p class="text-danger">{{ errors.emailError }}</p>
                    </div>
                    <div class="login__field">
                        <input type="text" v-model="form.name" class="login__input" placeholder="Name">
                        <p class="text-danger">{{ errors.nameError }}</p>

                    </div>
                    <div class="login__field">
                        <input type="tel" v-model="form.phone" class="login__input"
                               placeholder="Phone ex. +374999999">
                        <p class="text-danger">{{ errors.phone }}</p>
                    </div>
                    <div class="login__field">
                        <input type="password" v-model="form.password" class="login__input" placeholder="Password">
                        <p class="text-danger">{{ errors.passwordError }}</p>
                    </div>
                    <div class="login__field">
                        <input type="password" v-model="form.confirmPassword" class="login__input"
                               placeholder="Confirm Password">
                        <p class="text-danger">{{ errors.confirmPasswordError }}</p>
                    </div>
                    <button class="button login__submit" @click.stop.prevent="sendData">
                        <span class="button__text">Register</span>

                    </button>
                    <div class="d-flex justify-content-end mt-4">
                        <router-link to="/login" class="text-decoration-none text-white router">
                            Sign in?
                        </router-link>
                    </div>
                </form>

            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
</template>
<script>
import {mapState, mapGetters} from 'vuex';

export default {
    name: "Register",
    data() {
        return {
            success: false,
            form: {
                email: '',
                name: '',
                password: '',
                confirmPassword: '',
                phone: '',
            },
            errors: {
                emailError: '',
                nameError: '',
                passwordError: '',
                confirmPasswordError: '',
                phone: '',
            },
            show: true,
            regexEmail: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
            regexPhone: /^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm
        }
    },
    methods: {
        async sendData() {
            if (!this.regexEmail.test(this.form.email) || this.form.password.length < 6 || this.form.name.length < 3 ||
                !this.form.phone.match(this.regexPhone) ) {

                if (!this.regexEmail.test(this.form.email) ){
                    this.errors.emailError = 'Invalid email'
                }else if ( this.form.password.length < 6){
                    this.errors.passwordError = 'Your password must be minimum 6 characters'

                }else if (this.form.name.length < 3) {
                    this.errors.nameError = 'Your name must be minimum 3 characters'
                }else if (!this.form.phone.match(this.regexPhone)) {
                    return this.errors.phone = 'Wrong number'
                }
                return this.errors.invalidData = 'Invalid Data'
            }
            let response = await this.$store.dispatch('registerRequest', this.form)
            if (response.success === 1)
            {
                this.$router.push({path: '/login'})
            }
        },
    },
    watch: {
        'form.email'(val) {

            if (!this.regexEmail.test(val)) {
                this.errors.emailError = 'Invalid email'
            } else {

                this.errors.emailError = ''
            }
        },
        'form.password'(val) {
            if (val.length < 6) {
                this.errors.passwordError = 'Your password must be minimum 6 characters'
            } else {
                this.errors.passwordError = ''
            }
        },
        'form.name'(val) {
            if (val.length < 3) {
                this.errors.nameError = 'Your name must be minimum 3 characters'
            } else {

                this.errors.nameError = ''
            }
        },
        'form.confirmPassword'(val) {
            if (val !== this.form.password) {
                this.errors.confirmPasswordError = 'Your password must be the same password'
            } else {
                this.errors.confirmPasswordError = ''
            }
        },
        'form.phone'(val) {
            if ( !this.form.phone.match(this.regexPhone)) {
                return this.errors.phone = 'Wrong number'
            }
            this.errors.phone = ''

        }
    }
}
</script>

<style scoped lang="scss">
.center {
    margin: auto;
    width: 50%;
    padding: 10px;
}

@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

* {
    overflow: hidden;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Raleway, sans-serif;
}

body {
    background: linear-gradient(90deg, #C7C5F4, #776BCC);
}

.container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.screen {
    background: linear-gradient(90deg, #5D54A4, #7C78B8);
    position: relative;
    height: 650px;
    width: 360px;
    box-shadow: 0px 0px 24px #5C5696;
}

.screen__content {
    z-index: 1;
    position: relative;
    height: 100%;
}

.screen__background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
    -webkit-clip-path: inset(0 0 0 0);
    clip-path: inset(0 0 0 0);
}

.screen__background__shape {
    transform: rotate(45deg);
    position: absolute;
}

.screen__background__shape1 {
    height: 520px;
    width: 520px;
    background: #FFF;
    top: -50px;
    right: 120px;
    border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
    height: 220px;
    width: 220px;
    background: #6C63AC;
    top: -172px;
    right: 0;
    border-radius: 32px;
}

.screen__background__shape3 {
    height: 540px;
    width: 190px;
    background: linear-gradient(270deg, #5D54A4, #6A679E);
    top: -24px;
    right: 0;
    border-radius: 32px;
}

.screen__background__shape4 {
    height: 400px;
    width: 200px;
    background: #7E7BB9;
    top: 420px;
    right: 50px;
    border-radius: 60px;
}

.login {
    width: 320px;
    padding: 30px;
}

.login__field {
    padding: 10px 0px;
    position: relative;
}

.login__icon {
    position: absolute;
    top: 30px;
    color: #7875B5;
}

.login__input {
    border: none;
    border-bottom: 2px solid #D1D1D4;
    background: none;
    padding: 5px;
    //padding-left: 24px;
    font-weight: 700;
    width: 75%;
    transition: .2s;
}

.login__input:active,
.login__input:focus,
.login__input:hover {
    outline: none;
    border-bottom-color: #6A679E;
}

.login__submit {
    background: #fff;
    font-size: 14px;
    margin-top: 30px;
    padding: 16px 20px;
    border-radius: 26px;
    border: 1px solid #D4D3E8;
    text-transform: uppercase;
    font-weight: 700;
    display: flex;
    align-items: center;
    width: 100%;
    color: #4C489D;
    box-shadow: 0px 2px 2px #5C5696;
    cursor: pointer;
    transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
    border-color: #6A679E;
    outline: none;
}

.button__icon {
    font-size: 24px;
    margin-left: auto;
    color: #7875B5;
}

.social-login {
    position: absolute;
    height: 140px;
    width: 160px;
    text-align: center;
    bottom: 0px;
    right: 0px;
    color: #fff;
}

.social-icons {
    display: flex;
    align-items: center;
    justify-content: center;
}

.social-login__icon {
    padding: 20px 10px;
    color: #fff;
    text-decoration: none;
    text-shadow: 0px 0px 8px #7875B5;
}

.social-login__icon:hover {
    transform: scale(1.5);
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>
