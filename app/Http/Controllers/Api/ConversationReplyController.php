<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Events\ConversationReplyCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConversationReplyRequest;
use App\Http\Resources\ConversationResource;

class ConversationReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(StoreConversationReplyRequest $request, Conversation $conversation)
    {
        $this->authorize('reply', $conversation);

        $reply = new Conversation();
        $reply->body = $request->get('body');
        $reply->user()->associate($request->user());

        $conversation->replies()->save($reply);
        $conversation->touchLastReply();

        $reply->load(['user', 'parent.user', 'parent.users']);

        broadcast(new ConversationReplyCreated($reply))->toOthers();

        return ConversationResource::make($reply);
    }
}
