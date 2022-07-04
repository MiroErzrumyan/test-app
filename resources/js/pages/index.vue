<template>
    <div>
        <div class="d-flex justify-content-center" v-if=" !showAll ">
            <h2 class="text-danger"> {{ noData }}</h2>
        </div>

        <div class="overflow-auto" v-if="show && items.length > 0">
            <div class="container mt-4">
                <div class="d-flex justify-content-center flex-wrap">
                    <div>
                        <input type="checkbox" id="checkbox" v-model="checked">
                        <label for="checkbox"> Show my offices</label>
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    <h2 class="text-danger"> {{ deletedMessage }}</h2>
                </div>
            </div>

            <div class="container" v-if="showAll">
                <div class="row">
                    <div v-for="item in items" class="col-5 offset-1 mt-4">

                        <b-card :title="  item.name" class="officeCard">
                            <div class="d-flex">
                                <a class="updateIcon" href="" @click.stop.prevent>
                                    <b-icon icon="eyedropper" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            @click="updateOffice = item" v-if="user.id === item.user_id"
                                            class="text-info icon "></b-icon>
                                </a>
                                <a href="" @click.stop.prevent="destroy">
                                    <b-icon icon="trash-fill" v-if="user.id === item.user_id"
                                            class="text-danger icon mx-4" @click="deleteOffice = item.id">
                                    </b-icon>
                                </a>


                            </div>

                            <b-card-text class="mt-2 mb-2">
                                <h5 class="d-inline">locations:</h5>
                                <span v-for="(location,index) in item.locations" class="small">
                                    {{
                                        index + 1 === item.locations.length ? location.address_1 + '.' : location.address_1 + ',' + ' '
                                    }}
                             </span>
                            </b-card-text>
                        </b-card>
                    </div>

                </div>
            </div>


            <modal :office="updateOffice" @update="update"></modal>
            <b-container class="mb-5 mt-5" v-if="loader">
                <div id="floatBarsG">
                    <div id="floatBarsG_1" class="floatBarsG"></div>
                    <div id="floatBarsG_2" class="floatBarsG"></div>
                    <div id="floatBarsG_3" class="floatBarsG"></div>
                    <div id="floatBarsG_4" class="floatBarsG"></div>
                    <div id="floatBarsG_5" class="floatBarsG"></div>
                    <div id="floatBarsG_6" class="floatBarsG"></div>
                    <div id="floatBarsG_7" class="floatBarsG"></div>
                    <div id="floatBarsG_8" class="floatBarsG"></div>
                </div>
            </b-container>
            <footer class="mt-5 "></footer>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "index",
    data() {
        return {
            show: false,
            skip: 0,
            items: [],
            checked: false,
            loader: false,
            scroll: true,
            modal: '',
            modalAnswer: '',
            updateOffice: {},
            deleteOffice: '',
            deletedMessage: '',
            noData: '',
            showAll: true,
            boxTwo: ''

        }
    },

    components: {
        modal: () => import('../components/Modal')
    },
    computed: {
        ...mapGetters(['offices', 'user']),

    },
    watch: {
        checked(val) {
            if (val === true) {
                this.skip = 0
                this.loader = false
            }
            this.getData()
        },
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        ...mapActions(['getOffices']),

        async handleScroll() {
            if (window.scrollY + window.innerHeight === document.documentElement.offsetHeight && this.scroll) {
                this.loader = true
                let response = await axios.get('/api/office', {
                    params: {
                        checked: this.checked,
                        skip: this.skip,
                    }
                });
                let data = response.data.data

                if (data.success === 1 && data.offices.length > 0) {
                    setTimeout(() => {
                        for (let i = 0; i < data.offices.length; i++) {
                            this.items.push(data.offices[i])
                        }
                    }, 500)
                    return this.skip = this.skip + data.offices.length
                }
                return [this.scroll = false, this.loader = false]
            }
        },
        update() {
            this.skip = 0
            this.getData()
        },
        async confirmation() {
            this.boxTwo = ''
            let response = await this.$bvModal.msgBoxConfirm('Please confirm that you want to delete your office.', {
                title: 'Please Confirm',
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'danger',
                okTitle: 'YES',
                cancelTitle: 'NO',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true
            })
            return response
        },
        async destroy() {

            let confirmAnswer = await this.confirmation()
            if (confirmAnswer) {
                let response = await axios.delete(`/api/office/${this.deleteOffice}`)
                if (response.data.data.success === 1) {
                    this.deletedMessage = ''
                    this.skip = 0
                    return this.getData()
                }
                this.deletedMessage = 'Your office was not delete'
            }
        },
        async getData() {
            let response = await this.getOffices({'checked': this.checked, 'skip': this.skip})
            this.loader = false
            if (response.success === 1) {
                if (response.offices.length > 0){
                    this.noData = ''
                    this.showAll = true
                    this.skip = this.skip + this.offices.length
                    this.items = this.offices
                    this.total = this.offices.last_page
                    this.show = true
                    return this.rows = this.offices.total
                }
                this.showAll = false
                return this.noData = 'There are no data'
            }
            if (this.checked) {
                this.showAll = false
                return this.noData = "You don't have office"
            }
            return this.noData = 'There are no data'
        },
    },
    mounted() {
        this.getData()
    }
}
</script>

<style scoped lang="scss">
.officeCard {
    height: 180px;
    overflow-y: auto;
}

#floatBarsG {
    position: relative;
    width: 234px;
    height: 28px;
    margin: auto;
    margin-top: 13%;
}

.floatBarsG {
    position: absolute;
    top: 0;
    background-color: rgb(0, 0, 0);
    width: 28px;
    height: 28px;
    animation-name: bounce_floatBarsG;
    -o-animation-name: bounce_floatBarsG;
    -ms-animation-name: bounce_floatBarsG;
    -webkit-animation-name: bounce_floatBarsG;
    -moz-animation-name: bounce_floatBarsG;
    animation-duration: 1.5s;
    -o-animation-duration: 1.5s;
    -ms-animation-duration: 1.5s;
    -webkit-animation-duration: 1.5s;
    -moz-animation-duration: 1.5s;
    animation-iteration-count: infinite;
    -o-animation-iteration-count: infinite;
    -ms-animation-iteration-count: infinite;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-direction: normal;
    -o-animation-direction: normal;
    -ms-animation-direction: normal;
    -webkit-animation-direction: normal;
    -moz-animation-direction: normal;
    transform: scale(.3);
    -o-transform: scale(.3);
    -ms-transform: scale(.3);
    -webkit-transform: scale(.3);
    -moz-transform: scale(.3);
}

#floatBarsG_1 {
    left: 0;
    animation-delay: 0.6s;
    -o-animation-delay: 0.6s;
    -ms-animation-delay: 0.6s;
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
}

#floatBarsG_2 {
    left: 29px;
    animation-delay: 0.75s;
    -o-animation-delay: 0.75s;
    -ms-animation-delay: 0.75s;
    -webkit-animation-delay: 0.75s;
    -moz-animation-delay: 0.75s;
}

#floatBarsG_3 {
    left: 58px;
    animation-delay: 0.9s;
    -o-animation-delay: 0.9s;
    -ms-animation-delay: 0.9s;
    -webkit-animation-delay: 0.9s;
    -moz-animation-delay: 0.9s;
}

#floatBarsG_4 {
    left: 88px;
    animation-delay: 1.05s;
    -o-animation-delay: 1.05s;
    -ms-animation-delay: 1.05s;
    -webkit-animation-delay: 1.05s;
    -moz-animation-delay: 1.05s;
}

#floatBarsG_5 {
    left: 117px;
    animation-delay: 1.2s;
    -o-animation-delay: 1.2s;
    -ms-animation-delay: 1.2s;
    -webkit-animation-delay: 1.2s;
    -moz-animation-delay: 1.2s;
}

#floatBarsG_6 {
    left: 146px;
    animation-delay: 1.35s;
    -o-animation-delay: 1.35s;
    -ms-animation-delay: 1.35s;
    -webkit-animation-delay: 1.35s;
    -moz-animation-delay: 1.35s;
}

#floatBarsG_7 {
    left: 175px;
    animation-delay: 1.5s;
    -o-animation-delay: 1.5s;
    -ms-animation-delay: 1.5s;
    -webkit-animation-delay: 1.5s;
    -moz-animation-delay: 1.5s;
}

#floatBarsG_8 {
    left: 205px;
    animation-delay: 1.64s;
    -o-animation-delay: 1.64s;
    -ms-animation-delay: 1.64s;
    -webkit-animation-delay: 1.64s;
    -moz-animation-delay: 1.64s;
}


@keyframes bounce_floatBarsG {
    0% {
        transform: scale(1);
        background-color: rgb(0, 0, 0);
    }

    100% {
        transform: scale(.3);
        background-color: rgb(255, 255, 255);
    }
}

@-o-keyframes bounce_floatBarsG {
    0% {
        -o-transform: scale(1);
        background-color: rgb(0, 0, 0);
    }

    100% {
        -o-transform: scale(.3);
        background-color: rgb(255, 255, 255);
    }
}

@-ms-keyframes bounce_floatBarsG {
    0% {
        -ms-transform: scale(1);
        background-color: rgb(0, 0, 0);
    }

    100% {
        -ms-transform: scale(.3);
        background-color: rgb(255, 255, 255);
    }
}

@-webkit-keyframes bounce_floatBarsG {
    0% {
        -webkit-transform: scale(1);
        background-color: rgb(0, 0, 0);
    }

    100% {
        -webkit-transform: scale(.3);
        background-color: rgb(255, 255, 255);
    }
}

@-moz-keyframes bounce_floatBarsG {
    0% {
        -moz-transform: scale(1);
        background-color: rgb(0, 0, 0);
    }

    100% {
        -moz-transform: scale(.3);
        background-color: rgb(255, 255, 255);
    }
}

.icon {
    width: 25px;
    height: 25px;
}


</style>
