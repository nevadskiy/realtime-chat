<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConversationUserRequest;
use App\Http\Resources\ConversationResource;

class ConversationUserController extends Controller
{
    public function store(StoreConversationUserRequest $request, Conversation $conversation)
    {
        $conversation->users()->syncWithoutDetaching($request->get('users'));

        return ConversationResource::make(
            $conversation->load(['user', 'users'])
        );
    }
}
