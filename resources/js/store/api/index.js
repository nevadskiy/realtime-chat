import axios from 'axios';

export default {
  getConversations(page) {
    return axios.get('/webapi/conversations?page=' + page);
  },

  getConversation(id) {
    return axios.get(`/webapi/conversations/${id}`);
  },

  storeConversationReply(id, {body}) {
    return axios.post(`/webapi/conversations/${id}/reply`, {body})
  },

  storeConversation({body, recipientIds}) {
    return axios.post(`/webapi/conversations/`, {
      body: body,
      recipients: recipientIds,
    })
  }
};
