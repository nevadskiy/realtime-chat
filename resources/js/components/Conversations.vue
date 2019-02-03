<template>
    <div class="card panel-default">
        <div class="card-body">
            <div class="card-title">All conversations</div>

            <div v-if="loading" class="loader">Loading...</div>

            <div v-else-if="conversations.length" class="media" v-for="conversation in conversations" :key="conversation.id">
                <div class="media-body">
                    <a href="">{{ trunc(conversation.body, 50) }}</a>
                    <p class="text-muted">You and {{ conversation.participant_count }} {{ pluralize('other', conversation.participant_count) }}</p>
                    <ul class="list-inline">
                        <li class="list-inline-item" v-for="user in conversation.users" :key="user.id">
                            <img
                                    :src="user.avatar"
                                    :title="user.name"
                                    :alt="user.name + ' avatar'"
                            >
                        </li>
                        <li class="list-inline-item">
                            Last reply {{ conversation.last_reply_human }}
                        </li>
                    </ul>
                </div>
            </div>
            <p v-else>No conversations yet</p>
        </div>
    </div>
</template>

<script>
  import trunc from '../utilities/trunc';
  import pluralize from 'pluralize';
  import {mapActions, mapGetters} from 'vuex';

  export default {
    computed: {
      ...mapGetters({
        conversations: 'allConversations',
        loading: 'loadingConversations'
      })
    },

    methods: {
      ...mapActions({
        getConversations: 'getConversations',
      }),
      trunc: trunc,
      pluralize: pluralize,
    },

    created() {
      this.getConversations(1);
    },
  }
</script>
