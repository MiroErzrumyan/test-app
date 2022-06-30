import Vue from 'vue'

const store = ({
    state: {
        user : {},
    },
    getters: {
        user:state => state.user,
    },
    mutations: {
        SET_USER(state,user){
            state.user = user
        },
        REMOVE_USER(state){
            state.user = {}
        }

    },
    actions: {
        async loginRequest(context,data) {
            try {
                let response = await axios.post('api/login' , data);
                if (response.data.data.success === 1){

                    let user = response.data.data.user
                    context.commit('SET_USER',user)
                    Vue.prototype.$cookies.set("token", response.data.data.accessToken,'7d');
                }

                return response.data.data
            }catch (error){
                console.log(error)

            }
        },
        async removeAuth(context){
            try {
                context.commit('REMOVE_USER')
                Vue.prototype.$cookies.remove("token");
                return {'success' : 1}
            }catch (e){
                console.log(e)
            }
        }
    }
})

export default store;

