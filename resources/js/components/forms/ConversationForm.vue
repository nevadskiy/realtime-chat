<template>
    <div class="card">
        <h3 class="card-header">New message</h3>
        <div class="card-body">
            <form @submit.prevent="send">
                <div class="form-group dropdown">
                    <input v-model="search" type="text" class="form-control" placeholder="Start typing to find users">
                    <div class="dropdown-menu w-100" :class="{show: showDropdown}">
                        <template v-if="users.length">
                            <a
                                    v-for="user in users"
                                    :key="user.id"
                                    class="dropdown-item"
                                    role="button"
                                    @click="addRecipient(user)"
                                    v-text="user.name"
                            ></a>
                        </template>
                        <span v-else-if="!pending" class="dropdown-item">Cannot find any user</span>
                        <span v-else class="dropdown-item">Loading...</span>
                    </div>
                </div>

                <ul v-if="recipients.length" class="list-inline">
                    <li class="list-inline-item"><strong>To:</strong></li>
                    <li
                            v-for="recipient in recipients"
                            :key="recipient.id"
                            class="list-inline-item"
                    >
                        {{ recipient.name }} [<a role="button" @click.prevent="removeRecipient(recipient)">X</a>]
                    </li>
                </ul>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" cols="30" rows="4" class="form-control" v-model="body"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import {mapActions} from 'vuex';

  export default {
    data() {
      return {
        search: '',
        users: [],
        pending: false,
        body: '',
        recipients: [],
      };
    },

    computed: {
      showDropdown() {
        return this.search.length;
      }
    },

    watch: {
      search() {
        if (this.search.length) {
          this.searchUsers();
        } else {
          this.users = [];
        }
      },
    },

    methods: {
      ...mapActions({
        createConversation: 'createConversation',
      }),

      searchUsers() {
        this.pending = true;

        axios.get('/webapi/search/users', {
          params: {
            query: this.search
          }
        }).then((response) => {
          this.users = response.data;
          this.pending = false;
        })
      },

      addRecipient(recipient) {
        this.search = '';

        if (this.recipients.find(r => r.id === recipient.id)) {
          return;
        }

        this.recipients.push(recipient);
      },

      removeRecipient(index) {
        this.recipients.splice(index, 1);
      },

      send() {
        this.$store.dispatch('createConversation', {
          body: this.body,
          recipientIds: this.recipients.map(r => r.id),
        }).then(() => {
          this.recipients = [];
          this.body = '';
        });
      }
    },
  }
</script>