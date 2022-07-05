<template>
    <div class="container text-center">

        <h2 class="text-danger" v-if="!show"> {{errors.noOffice}}</h2>
        <h2 class="text-danger" > {{errors.noCreate}}</h2>
        <section class="get-in-touch " v-if="show">
            <h1 class="title">Create team for your office</h1>
            <form class="contact-form  text-center">
                <h3 class="text-danger" >{{ errors.formError }}</h3>
                <div class="form-field w-50">
                    <label class="label" for="name">Team Name</label>
                    <input id="name" class="input-text js-input" type="text" v-model="form.name">
                </div>
                <div class="form-field w-50">
                    <label class="selectLabel mb-2" for="select">Select office</label>
                    <multiselect id="select" v-model="selected" track-by="name" label="name" :options="options"
                                 :searchable="false" :close-on-select="true" :show-labels="false"
                                 placeholder="Pick a value"></multiselect>
                    <p class="mt-3">Office : {{ selected.name }}</p>
                </div>
                <div class="form-field ">
                    <button class="submit-btn" type="submit" @click.stop.prevent="sendData">Create</button>
                </div>
            </form>
        </section>
    </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

export default {
    name: "CreateTeam",
    components: {Multiselect},
    data() {
        return {
            form: {
                name: '',
            },
            selected: [],
            options: [],
            show: false,
            errors: {
                noOffice: '',
                formError : '',
                noCreate: '',
            }
        }
    },
    methods: {
        async getOffices() {
            let response = await axios.get(`/api/user/office`)
            let data = response.data.data
            if (data.success === 1 && data.offices.length > 0) {
                this.errors.noOffice = ''
                this.show = true
                return this.options = data.offices
            }
            this.errors.noOffice = "You haven't office"
            this.show = false
        },
        async sendData() {
            if (Object.keys(this.selected).length && this.form.name.length > 3){
                let team = {
                    'name': this.form.name,
                    'office_id': this.selected.id,
                }
                let response = await axios.post('/api/team', team)
                let data = response.data.data
                if (data.success === 1 && Object.keys(data.office).length){
                    return this.$router.push({path: '/'})

                }
                return  this.errors.noCreate = 'Everything Went wrong'
            }

            if (!Object.keys(this.selected).length && this.form.name.length < 4 ){
                this.errors.formError = 'Required Name and Office'
            }else if (!Object.keys(this.selected).length ){
                this.errors.formError = 'Required Office'
            }else if (this.form.name.length < 4){
                this.errors.formError = 'Name must be minimum 4 character'
            }else {
                this.errors.formError = 'Wrong name or office'
            }

        }
    },

    mounted() {
        this.getOffices()
    }
}
</script>

<style scoped lang="scss">

.get-in-touch {
    max-width: 800px;
    margin: 50px auto;
    position: relative;

}

.get-in-touch .title {
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 2.5em;
    line-height: 48px;
    padding-bottom: 48px;
    color: #5543ca;
    background: #5543ca;
    background: -moz-linear-gradient(left, #f4524d 0%, #5543ca 100%) !important;
    background: -webkit-linear-gradient(left, #f4524d 0%, #5543ca 100%) !important;
    background: linear-gradient(to right, #f4524d 0%, #5543ca 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
}

.contact-form .form-field {
    position: relative;
    margin: 32px auto;
}

.contact-form .input-text {
    display: block;
    width: 100%;
    height: 36px;
    border-width: 0 0 2px 0;
    border-color: #5543ca;
    font-size: 18px;
    line-height: 26px;
    font-weight: 400;
}

.contact-form .input-text:focus {
    outline: none;
}

.contact-form .label {
    font-weight: 400;
    color: #5543ca;
}

.contact-form .submit-btn {
    display: inline-block;
    background-color: #000;
    background-image: linear-gradient(125deg, #a72879, #064497);
    color: #fff;
    letter-spacing: 2px;
    font-size: 16px;
    padding: 8px 16px;
    border: none;
    width: 200px;
    cursor: pointer;
}

.selectLabel {
    color: #5543ca;
}

</style>
