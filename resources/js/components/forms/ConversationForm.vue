<template>
    <div class="card">
        <h3 class="card-header">New message</h3>
        <div class="card-body">
            <div class="form-group dropdown">
                <input v-model="search" type="text" class="form-control" placeholder="Start typing to find users">
                <div class="dropdown-menu w-100" :class="{show: showDropdown}">
                    <template v-if="users.length">
                        <a v-for="user in users" :key="user.id" class="dropdown-item">
                            {{ user.name }}
                        </a>
                    </template>
                    <span v-else-if="!pending" class="dropdown-item">Cannot find any user</span>
                    <span v-else class="dropdown-item">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        search: '',
        users: [],
        pending: false,
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
      }
    },

    mounted() {
      //
    }
  }
</script>