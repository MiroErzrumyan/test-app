<template>
    <div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="border-1 p-3">
                            <div class="d-flex justify-content-center">
                                <h2>Update your office</h2>
                            </div>
                            <div v-if="updated"><h4 class="text-success text-center" >Your product updated successfully</h4></div>
                            <div >
                                <h4 class="text-danger text-center" >{{ error }} </h4>
                            </div>
                            <div class="d-flex justify-content-center"></div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Office name</label>
                                <input v-model="name" type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp"
                                       placeholder="Enter office name" >
                            </div>
                            <div class="mt-4 border-2">
                                <div class=" border-2">
                                    <multiselect v-model="selected" :options="locations" :limit="1" :multiple="true"
                                                 :close-on-select="false" :clear-on-select="false"
                                                 :preserve-search="true" placeholder="Pick some" label="address_1"
                                                 track-by="address_1" :preselect-first="true">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" @click.stop.prevent="sendData" >Update</button>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

require('vue-multiselect/dist/vue-multiselect.min.css')
export default {
    name: "Modal",
    data() {
        return {
            locations: [],
            selected: [],
            name: '',
            updated:false,
            error : ''
        }
    },
    props: {
        office: Object,
    },
    watch: {
        office(val) {
            if (Object.keys(val).length >= 1) {
                this.selected = val.locations
                this.name = val.name
            }
        },
    },
    components: {Multiselect},
    methods: {
        async sendData() {
            if (Object.keys(this.selected).length && this.name.length >= 3) {
                try {
                    let officeLocationsId = [];
                    for (let i = 0;i < this.selected.length;i++){
                        officeLocationsId.push(this.selected[i].id)
                    }

                    let office = {
                        'id' : this.office.id,
                        'name': this.name,
                        'locations': officeLocationsId
                    }
                    let response = await axios.put(`/api/office/${this.office.id}`,office)
                    if (response.data.data.success === 1 ) {
                        this.error = ''
                        this.updated = true
                        return this.$emit('update')
                    }
                }catch (e){
                    if (e.response.status === 422) {
                        this.error = 'The name already exists'
                        return this.updated = false
                    }
                }
            }
            if (this.selected.length === 0 && this.name.length === 0 ){
                return this.error = 'Location and name required'
            }else if (this.selected.length === 0){
                return this.error = 'Location is required'
            }else if (this.name.length === 0){
                return this.error = 'Office name is required'
            }
            this.error = 'Invalid Data'
            return this.updated = false

        }
    },
    async mounted() {
        let response = await axios.get('/api/locations')
        let data = response.data.data
        if (data.success === 1) {
            this.locations = data.locations
            this.selected = this.office.locations
        }
    }
}
</script>

<style scoped>

</style>
