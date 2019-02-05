<template>
    <form @submit.prevent="send">
        <div class="form-group dropdown">
            <input v-model="search" type="text" class="form-control" placeholder="Add users">
            <div class="dropdown-menu w-100" :class="{show: showDropdown}">
                <template v-if="users.length">
                    <a
                            v-for="user in users"
                            :key="user.id"
                            class="dropdown-item"
                            role="button"
                            @click="addUser(user)"
                            v-text="user.name"
                    ></a>
                </template>
                <span v-else-if="!pending" class="dropdown-item">Cannot find any user</span>
                <span v-else class="dropdown-item">Loading...</span>
            </div>
        </div>

        <ul v-if="selectedUsers.length" class="list-inline">
            <li
                    v-for="(user, index) in selectedUsers"
                    :key="user.id"
                    class="list-inline-item"
            >
                {{ user.name }} [<a role="button" @click.prevent="removeUser(index)">X</a>]
            </li>
        </ul>

        <div v-if="selectedUsers.length" class="form-group">
            <button class="btn btn-default">Attach</button>
        </div>
    </form>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';

  export default {
    data() {
      return {
        search: '',
        users: [],
        pending: false,
        selectedUsers: [],
      };
    },

    computed: {
      ...mapGetters({
        conversation: 'currentConversation',
      }),

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
        addConversationUsers: 'addConversationUsers',
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

      addUser(user) {
        this.search = '';

        if (this.selectedUsers.find(r => r.id === user.id)) {
          return;
        }

        this.selectedUsers.push(user);
      },

      removeUser(index) {
        this.selectedUsers.splice(index, 1);
      },

      send() {
        this.$store.dispatch('addConversationUsers', {
          id: this.conversation.id,
          userIds: this.selectedUsers.map(u => u.id),
        }).then(() => {
          this.selectedUsers = [];
        });
      }
    },
  }
</script>
