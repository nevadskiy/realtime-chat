<?php

namespace App\Http\Controllers;

use App\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('conversations.index');
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        return view('conversations.index', compact('conversation'));
    }
}
