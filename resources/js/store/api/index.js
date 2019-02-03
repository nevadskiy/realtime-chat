import axios from 'axios';

export default {
  getConversations(page) {
    return axios.get('/webapi/conversations?page=' + page);
  },

  getConversation(id) {
    return axios.get(`/webapi/conversations/${id}`);
  }
};
