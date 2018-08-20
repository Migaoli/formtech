import axios from 'axios';
import _ from 'lodash';

const state = {
    loading: false,
    blocks: {},
};

const getters = {};

const actions = {
    fetch({dispatch, commit}) {
        commit('loading', true);

        return axios
            .get(`api/blocks`)
            .then(response => {
                commit('blocks', _.keyBy(response.data, 'name'));
                return response;
            })
            .finally(() => {
                commit('loading', false)
            })
    }
};

const mutations = {
    blocks(state, value) {
        state.blocks = value;
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