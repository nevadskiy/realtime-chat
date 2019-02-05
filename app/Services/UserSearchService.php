<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\DB;

class UserSearchService
{
    public function search(string $query, int $limit = 10)
    {
        return User::where(DB::raw('LOWER(name)'), 'LIKE', "%{$query}%")->take($limit)->get();
    }
}
