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
  addUsersToConversation(state, users) {
    users.forEach((user) => {
      let exists = state.conversation.users.some((u) => {
        return u.id === user.id;
      });

      if (!exists) {
        state.conversation.users.push(user);
      }
    });
  }
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
        commit('prependToConversations', response.data.data.parent);
      });
  },

  createConversation({commit, dispatch}, {body, recipientIds}) {
    return api.storeConversation({body, recipientIds})
      .then((response) => {
        dispatch('getConversation', response.data.data.id);
        commit('prependToConversations', response.data.data);
      });
  },

  addConversationUsers({commit, dispatch}, {id, userIds}) {
    return api.storeConversationUsers(id, {userIds})
      .then((response) => {
        commit('addUsersToConversation', response.data.data.users);
        commit('updateConversationInList', response.data.data);
      });
  },
};

export default {
  state,
  getters,
  mutations,
  actions,
};
