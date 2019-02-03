import api from '../api';
import conversation from './conversation';

const state = {
  conversations: [],
  loadingConversations: false,
};

const getters = {
  allConversations: state => state.conversations,
  loadingConversations: state => state.loadingConversations,
};

const mutations = {
  setConversations(state, conversations) {
    state.conversations = conversations
  },
  setConversationsLoading(state, status) {
    state.loadingConversations = status;
  }
};

const actions = {
  getConversations({dispatch, commit}, page) {
    commit('setConversationsLoading', true);

    api.getConversations(page).then((response) => {
      commit('setConversations', response.data.data);
      commit('setConversationsLoading', false);
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
