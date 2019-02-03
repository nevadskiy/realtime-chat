<?php

namespace App\Http\Resources;

use App\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Conversation $resource
 */
class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'parent_id' => $this->resource->parent_id,
            'body' => $this->resource->body,
            'created_at_human' => $this->resource->created_at->diffForHumans(),
            'last_reply_human' => $this->resource->last_reply ? $this->resource->last_reply->diffForHumans() : null,
            'participant_count' => $this->resource->usersExceptCurrentlyAuthenticated->count(),
            'replies' => static::collection($this->whenLoaded('replies')),
            'parent' => static::make($this->whenLoaded('parent')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
