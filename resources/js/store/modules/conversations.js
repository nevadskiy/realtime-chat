import api from '../api';
import conversation from './conversation';

const state = {
  conversation: [],
  loadingConversations: false,
};

const getters = {

};

const mutations = {

};

const actions = {
  getConversations({dispatch, commit}, page) {
    api.getConversations(1).then((response) => {
      commit('setConversations', response.data)
    });
  }
};

const modules = {
  conversation: conversation,
};

export default {
  state,
  getters,
  mutations,
  actions,
  modules,
};
