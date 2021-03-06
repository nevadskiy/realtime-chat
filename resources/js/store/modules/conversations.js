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
  },
  prependToConversations(state, conversation) {
    state.conversations = state.conversations.filter(c => c.id !== conversation.id);
    state.conversations.unshift(conversation);
  },
  updateConversationInList(state, conversation) {
    state.conversations = state.conversations.map((c) => {
      if (c.id === conversation.id) {
        return conversation;
      }

      return c;
    })
  },
};

const actions = {
  getConversations({dispatch, commit}, page) {
    commit('setConversationsLoading', true);

    api.getConversations(page).then((response) => {
      commit('setConversations', response.data.data);
      commit('setConversationsLoading', false);

      Echo.private(`user.${app.user.id}`)
        .listen('ConversationCreated', (conversation) => {
          commit('prependToConversations', conversation);
        })
        .listen('ConversationReplyCreated', (conversation) => {
          commit('prependToConversations', conversation.parent);
        })
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
