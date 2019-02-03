<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <conversations></conversations>
            </div>
            <div class="col-md-7">
                Conversation
            </div>
        </div>
    </div>
</template>

<script>
  import Conversations from './Conversations.vue';

  export default {
    name: 'conversations-dashboard',

    components: {
      conversations: Conversations,
    },
  }
</script>
