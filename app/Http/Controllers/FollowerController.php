<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowerController extends Controller {
    
    public function followUnfollow(User $user) {
        $user->followers()->toggle(auth()->user());
        
        return response()->json([
            'followersCount' => $user->followers()->count(),
        ]);
    }

}