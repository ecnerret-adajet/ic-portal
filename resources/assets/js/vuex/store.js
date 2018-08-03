export default {
    state: {
        currentUser: []
    },
    getters: {},
    actions: {
        authUser({ commit }) {
            return axios.get('/currentUser')
            .then(response => commit('SET_USER',response.data.data.role.permissions))
        }
    },
    mutations: {
        SET_USER(state, currentUser) {
            state.currentUser = currentUser
        }
    },
}
