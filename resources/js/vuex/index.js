import Vue from 'vue'
import Vuex from 'vuex'
import login from "./login";
import register from "./register";
import office from "./office";

const storeObject = {
    modules : {
        login,
        register,
        office
    }
}
Vue.use(Vuex)
export default new Vuex.Store(storeObject)

