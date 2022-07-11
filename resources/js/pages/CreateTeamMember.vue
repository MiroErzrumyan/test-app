<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <h2 class="card-title text-center">Make your team members</h2>
                        <h3 class="card-title text-center text-danger">{{errors.mainError}}</h3>
                        <div class="card-body py-md-4">
                            <form>
                                <div class="form-group">
                                    <input type="text" v-model="form.name" class="form-control" id="name"
                                           placeholder="Name">
                                    <p class="text-danger">{{ errors.nameError }}</p>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="form.email" class="form-control" id="email"
                                           placeholder="Email">
                                    <p class="text-danger">{{ errors.emailError }}</p>

                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" v-model="form.phone" id="phone"
                                           placeholder="Phone ex. +374999999">
                                    <p class="text-danger">{{ errors.phone }}</p>

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="position" v-model="form.position"
                                           placeholder="position (as desired)">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="employee" v-model="form.employee"
                                           placeholder="Employee (as desired)">
                                </div>

                                <div class="d-flex flex-row align-items-center justify-content-between">
                                    <button class="btn btn-primary" @click.stop.prevent="sendData">Create Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";

export default {
    name: "CreateTeamMember",
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                employee: '',
                position: '',

            },
            errors: {
                phone: '',
                nameError: '',
                emailError: '',
                mainError:'',
            },
            regexEmail: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
            regexPhone: /^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm
        }
    },
    computed: {
        ...mapGetters(['user']),
    },
    methods: {
        async sendData() {

            if (!this.regexEmail.test(this.form.email) || this.form.name.length < 3 ||
                 !this.form.phone.match(this.regexPhone)  || this.form.phone.charAt(0) !== '+' ) {

                if (!this.regexEmail.test(this.form.email)) {
                    this.errors.emailError = 'Invalid email'
                }
                if (this.form.name.length < 3) {

                    this.errors.nameError = 'Your name must be minimum 3 characters'
                }
                if (!this.form.phone.match(this.regexPhone) || this.form.phone.length > 3 ) {
                    this.errors.phone = 'Wrong number'
                }
                if (this.form.phone.charAt(0) !== '+'){
                    this.errors.phone = "Phone must be start of '+' symbol, ex. +99999999"

                }
                return
            }
            let response = await axios.post(`/api/team/createMember/${this.$route.params.id}`, this.form)
            let data = response.data.data
            if (data.success === 1) {
                this.errors.mainError = ''
               return await this.$router.push({path: '/'})
            }
            return this.errors.mainError = 'Your member did not created'

        }
    },
    watch: {
        'form.email'(val) {

            if (!this.regexEmail.test(val)) {
                this.errors.emailError = 'Invalid email'
            } else {

                this.errors.emailError = ''
            }
        },
        'form.name'(val) {
            if (val.length < 3) {
                this.errors.nameError = 'Your name must be minimum 3 characters'
            } else {

                this.errors.nameError = ''
            }
        },
        'form.phone'(val) {
            if (!this.form.phone.match(this.regexPhone)) {
                return this.errors.phone = 'Wrong number'
            }
            this.errors.phone = ''
        }
    }
}
</script>

<style scoped lang="scss">
@import url('https://fonts.googleapis.com/css?family=PT+Sans');

body {
    background: #fff;
    font-family: 'PT Sans', sans-serif;
}

h2 {
    padding-top: 1.5rem;
}

a {
    color: #333;
}

a:hover {
    color: #da5767;
    text-decoration: none;
}

.card {
    border: 0.40rem solid #f8f9fa;
    top: 10%;
}

.form-control {
    background-color: #f8f9fa;
    padding: 20px;
    padding: 25px 15px;
    margin-bottom: 1.3rem;
}

.form-control:focus {

    color: #000000;
    background-color: #ffffff;
    border: 3px solid #8e57da;
    outline: 0;
    box-shadow: none;

}

.btn {
    padding: 0.6rem 1.2rem;
    background: #8e57da;
    border: 2px solid #8e57da;
}

.btn-primary:hover {


    background-color: #6a4dd5;
    border-color: #6a4dd5;
    transition: .3s;

}
</style>
