<template>
    <div v-if="conversation">

        <ul class="list-inline" v-if="conversation.users.length">
            <li class="list-inline-item"><strong>In conversation: </strong></li>
            <li v-for="user in conversation.users" :key="user.id" class="list-inline-item">{{ user.name }}</li>
        </ul>

        <hr>

        <div class="card mb-2" v-for="reply in conversation.replies" :key="reply.id">
            <div class="card-body">
                <div class="media">
                    <div class="media-left mr-3">
                        <img :src="reply.user.avatar_45" :alt="reply.user.name + ' avatar'">
                    </div>
                    <div class="media-body">
                        <div>{{ reply.user.name }} &bull; {{ reply.created_at_human }}</div>
                        <div>{{ reply.body }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-left mr-3">
                        <img :src="conversation.user.avatar_45" :alt="conversation.user.name + ' avatar'">
                    </div>
                    <div class="media-body">
                        <div>{{ conversation.user.name }} &bull; {{ conversation.created_at_human }}</div>
                        <div>{{ conversation.body }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    computed: {
      ...mapGetters({
        conversation: 'currentConversation',
      })
    },

    methods: {
      ...mapActions({
        getConversations: 'getConversations',
        getConversation: 'getConversation',
      }),
    },
  }
</script>
