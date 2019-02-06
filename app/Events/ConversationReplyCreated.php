<?php

namespace App\Events;

use App\Conversation;
use App\Http\Resources\ConversationResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConversationReplyCreated implements ShouldBroadcast
{
    use InteractsWithSockets;

    /**
     * @var Conversation
     */
    private $conversation;

    /**
     * Create a new event instance.
     *
     * @param Conversation $conversation
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [
            new PrivateChannel("conversation.{$this->conversation->parent->id}")
        ];

        $this->conversation->parent->users->each(function ($user) use (&$channels) {
            $channels[] = new PrivateChannel("user.{$user->id}");
        });

        return $channels;
    }

    public function broadcastWith()
    {
        return ConversationResource::make($this->conversation)->resolve();
    }
}
