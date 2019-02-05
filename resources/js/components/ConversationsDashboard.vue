<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <conversation-form></conversation-form>
                <conversations :id="id"></conversations>
            </div>
            <div class="col-md-7">
                <conversation></conversation>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      id: {
        type: Number,
        default: null,
      },
    },
    name: 'conversations-dashboard',
  }
</script>
