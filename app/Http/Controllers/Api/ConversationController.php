<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Events\ConversationCreated;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Resources\ConversationResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $conversations = $request->user()
            ->conversations()
            ->with(['user', 'users', 'replies.user'])
            ->get();

        return ConversationResource::collection($conversations);
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        if ($conversation->isReply()) {
            abort(404);
        }

        return ConversationResource::make($conversation->load(['user', 'users', 'replies.user']));
    }

    public function store(StoreConversationRequest $request)
    {
        $conversation = new Conversation();
        $conversation->body = $request->get('body');
        $conversation->user()->associate(auth()->user());
        $conversation->save();

        $conversation->touchLastReply();

        $conversation->users()->sync($this->getRecipientIds($request));

        $conversation->load(['user', 'users', 'replies.user']);

        broadcast(new ConversationCreated($conversation))->toOthers();

        return ConversationResource::make($conversation);
    }

    private function getRecipientIds(Request $request): array
    {
        return array_unique(array_merge($request->get('recipients'), [auth()->id()]));
    }
}
