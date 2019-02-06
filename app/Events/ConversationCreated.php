<?php

namespace App\Events;

use App\Conversation;
use App\Http\Resources\ConversationResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ConversationCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Conversation
     */
    public $conversation;

    /**
     * Create a new event instance.
     *
     * @param Conversation $conversation
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;

        info(auth()->id());
    }

    /**
     * Get the channels the event should broadcast on.
     * Auth user cannot be got via auth()->user()
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];

        $this->conversation->users->each(function ($user) use (&$channels) {
            $channels[] = new PrivateChannel("user.{$user->id}");
        });

        return $channels;
    }

    public function broadcastWith()
    {
        return ConversationResource::make($this->conversation)->resolve();
    }
}
