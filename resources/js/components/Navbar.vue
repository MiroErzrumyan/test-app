<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                    aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <router-link to="/login" class="text-dark fs-5  text-decoration-none mx-4" v-show="show">Login
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/register" class="text-dark fs-5 text-decoration-none " v-show="show">Register</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/" class="text-dark fs-5 text-decoration-none mx-3"  v-show="!show">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/store" class="text-dark fs-5 text-decoration-none mx-3" v-show="!show">Create Office</router-link>
                    </li>
                    <li class="nav-item mx-2">
                        <a href="#"  class="text-dark fs-5 text-decoration-none"
                           v-show="!show" @click.stop.prevent="logout">
                            Log out
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";

export default {
    name: "Navbar",
    data() {
        return {
            show: true,
        }
    },
    computed: {
        ...mapGetters(['user']),

    },
    methods: {
        ...mapActions(['removeAuth']),

        async logout(){
          let response = await axios.post('/api/logout')
          let success = response.data.data.success
          if (success === 1){
              let response = await this.removeAuth()
              if (response.success === 1){
                  window.axios.defaults.headers.common['Authorization'] = '';
                  return this.$router.push({path:"/login"})
              }
          }
      }
    },
    watch: {
        user(val) {
            if (Object.keys(val).length > 1) {
                return this.show = false
            }
            return this.show = true
        },

    }
}
</script>

<style scoped>

</style>
