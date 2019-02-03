<?php

namespace App\Http\Controllers\Api;

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
}
