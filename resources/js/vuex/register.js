const store = ({
    state: {
        success: 0
    },
    getters: {
        success: state => state.success,
    },
    mutations: {
        SET_SUCCESS(state,data){
            state.success = data.success
        }
    },
    actions: {
        async registerRequest(context,data) {
            try {
                let response = await axios.post('/api/register' , data);
                context.commit('SET_SUCCESS',response.data.data)
                return response.data.data;
            }catch (error){
                console.log(error)

            }
        }
    }
})

export default store;

