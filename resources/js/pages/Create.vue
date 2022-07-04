<template>
    <div class="d-flex justify-content-center align-items-center">
        <div class="container mt-5">
            <div class="d-flex justify-content-center align-items-center ">

                <form class="border-1 p-3">
                    <div class="d-flex justify-content-center">
                        <h2>Create your office</h2>
                    </div>
                    <div class="d-flex justify-content-center">

                        <h3 class="text-danger">{{ invalidData }}</h3>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Office name</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" v-model="name"
                               aria-describedby="emailHelp"
                               placeholder="Enter office name">
                    </div>


                    <label for="multiSelect " class="mt-4">Office location</label>
                    <div class=" border-2">

                        <multiselect v-model="selected" :options="locations" :limit="1" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="address_1" track-by="address_1" :preselect-first="true">
                        </multiselect>
                    </div>
                    <div class="d-flex justify-content-center mt-5">

                        <button class="btn btn-primary" @click.stop.prevent="sendData">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
require('vue-multiselect/dist/vue-multiselect.min.css')
export default {
    name: "Create",
    data() {
        return {
            selected: [],
            locations: [],
            name: '',
            invalidData: '',
        }
    },
    components: {Multiselect},
    methods: {
        limitText(count) {
            return `and ${count} other countries`
        },
        async sendData() {
            if (Object.keys(this.selected).length && this.name.length >= 3) {
                try {
                    let officeLocationsId = [];
                    for (let i = 0;i < this.selected.length;i++){
                        officeLocationsId.push(this.selected[i].id)
                    }
                    let office = {
                        'name': this.name,
                        'locations': officeLocationsId,
                    }
                    let response = await axios.post('/api/office', office)
                    let data = response.data.data
                    if (data.success === 1) {
                        this.invalidData = ''
                        return this.$router.push({path: '/'})
                    }
                } catch (e) {
                    if (e.response.status === 422) {
                        return this.invalidData = 'The name already exists'
                    }
                }

            }
            this.invalidData = 'Invalid Data'
        }
    },
    async mounted() {
        let response = await axios.get('/api/locations')
        let data = response.data.data
        if (data.success === 1) {
            return this.locations = data.locations

        }
    }
}
</script>

<style scoped lang="scss">
.multiselect {
    max-height: 100px;
}

body {
    background: url("https://aie-internship.com/wp-content/uploads/Co-workers-working-in-start-up-office.jpg");
}
</style>
