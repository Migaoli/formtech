import axios from 'axios';

const state = {
    loading: false,
    theme: null,
};

const getters = {};

const actions = {
    fetch({dispatch, commit}) {
        commit('loading', true);

        return axios
            .get(`api/theme`)
            .then(response => {
                commit('theme', response.data);
                return response;
            })
            .finally(() => {
                commit('loading', false)
            })
    }
};

const mutations = {
    theme(state, value) {
        state.theme = value;
    },

    loading(state, value) {
        state.loading = value;
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}