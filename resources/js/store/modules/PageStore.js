import axios from 'axios';

const state = {
    loading: false,
    page: null,
};

const getters = {};

const actions = {
    fetch({dispatch, commit}, {id}) {
        commit('loading', true);

        return axios
            .get(`api/pages/${id}`)
            .then(response => {
                commit('page', response.data);
                return response;
            })
            .finally(() => {
                commit('loading', false)
            })
    }
};

const mutations = {
    loading(state, value) {
        state.loading = value;
    },

    page(state, value) {
        state.page = value
    },

    clear(state) {
        state.loading = false;
        state.page = null;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}