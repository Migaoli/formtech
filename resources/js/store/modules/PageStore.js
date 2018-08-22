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
    },

    deleteBlock({dispatch, commit, state}, {id}) {
        return axios
            .delete(`api/pages/${state.page.id}/blocks/${id}`)
            .then(response => {
                commit('blocks', state.page.blocks.filter(block => block.id !== id));
                return response;
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

    blocks(state, blocks) {
        state.page.blocks = blocks;
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