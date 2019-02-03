import api from '../api';

const state = {
  conversation: null,
  loadingConversation: false,
};

const getters = {
  currentConversation: state => state.conversation,
};

const mutations = {
  setConversation(state, conversation) {
    state.conversation = conversation;
  }
};

const actions = {
  getConversation({commit}, id) {
    api.getConversation(id).then((response) => {
      commit('setConversation', response.data.data)
    });
  },
};

export default {
  state,
  getters,
  mutations,
  actions,
};
