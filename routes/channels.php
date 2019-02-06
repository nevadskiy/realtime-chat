<?php

use App\Conversation;
use App\User;

Broadcast::channel('user.{id}', function (User $user, $id) {
    return $user->id === (int) $id;
});

Broadcast::channel('conversation.{id}', function (User $user, $id) {
    return $user->isInConversation(Conversation::find($id));
});
