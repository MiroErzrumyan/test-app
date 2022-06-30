<template>
    <div>
        <navbar ></navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from "../components/Navbar";
import {mapGetters, mapMutations} from "vuex";

export default {
    name: "App",
    data() {
        return {
        }
    },
    components: {Navbar},

    computed: {
        ...mapGetters(['user']),
    },
    methods: {
        ...mapMutations(['SET_USER']),

    },
    async mounted() {
        let token = this.$cookies.get('token')
        if (token) {
            if (!Object.keys(this.user).length) {
                try {
                    let response = await axios.get('/api/getAuth')
                    let user = response.data.data.user
                    if (user) {
                        this.SET_USER(user)
                        if (this.$route.fullPath === '/login' || this.$route.fullPath === '/register') {
                            return this.$router.push({path: '/'})
                        }
                        return
                    }
                    } catch (error) {
                    console.log('everything went wrong')
                    }

                if (this.$route.fullPath !== '/login') {
                    return this.$router.push({path: '/login'})
                }
            }
        }
    },
}
</script>
