<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Http\Requests\StoreConversationReplyRequest;
use App\Http\Resources\ConversationResource;
use Illuminate\Http\Request;

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

        return ConversationResource::make($conversation->load(['user', 'users']));
    }
}
