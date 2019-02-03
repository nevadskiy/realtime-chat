<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $dates = ['last_reply'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function usersExceptCurrentlyAuthenticated()
    {
        return $this->user()->where('user_id', '<>', auth()->id());
    }

    public function replies()
    {
        return $this->hasMany(static::class, 'parent_id')->latest();
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function touchLastReply()
    {
        $this->update(['last_reply' => $this->freshTimestamp()]);
    }

    public function isReply()
    {
        return $this->parent_id !== null;
    }
}
