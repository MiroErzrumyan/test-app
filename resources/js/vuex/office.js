import Vue from 'vue'

const store = ({
    state: {
        offices: {}
    },
    getters: {
        offices: state => state.offices
    },
    mutations: {
        SET_OFFICES(state,offices) {
            state.offices = offices
        }
    },
    actions: {
        async getOffices(context,skipData){

            let response = await axios.get('/api/office', {
                params: {
                     checked : skipData.checked,
                     skip : skipData.skip
                }
            });
            let data = response.data.data
            if(data.success === 1 ){
                context.commit('SET_OFFICES',data.offices)
            }
            return data
        }
    }
})

export default store;

