import api from '../api';

const state = {
  conversation: null,
  loadingConversation: false,
};

const getters = {
  currentConversation: state => state.conversation,
  loadingConversation: state => state.loadingConversation,
};

const mutations = {
  setConversation(state, conversation) {
    state.conversation = conversation;
  },
  setConversationLoading(state, status) {
    state.loadingConversation = status;
  },
  appendToConversation(state, reply) {
    state.conversation.replies.unshift(reply);
  },
};

const actions = {
  getConversation({commit}, id) {
    commit('setConversationLoading', true);

    api.getConversation(id).then((response) => {
      commit('setConversation', response.data.data);
      commit('setConversationLoading', false);

      window.history.pushState(null, null, `/conversations/${id}`);
    });
  },

  createConversationReply({commit}, {id, body}) {
    return api.storeConversationReply(id, {body})
      .then((response) => {
        commit('appendToConversation', response.data.data);
      });
  },
};

export default {
  state,
  getters,
  mutations,
  actions,
};
