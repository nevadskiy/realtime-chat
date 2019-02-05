<?php

namespace App\Http\Controllers\Api;

use App\Services\UserSearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    public function index(Request $request, UserSearchService $service)
    {
        $users = $service->search((string) $request->get('query'));

        return response()->json($users);
    }
}
