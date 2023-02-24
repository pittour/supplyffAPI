<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return $user->load('server');
    }

    public function update(User $user, Request $request)
    {

        if ($user->id !== auth()->user()->id) {
            return response()->json("Accès refusé", 403);
        }

        $user->update([
            'ingame_tag' => $request->ingame_tag,
            'discord_tag' => $request->discord_tag,
            'bio' => $request->bio,
        ]);

        return response()->json("Profil mis à jour", 201);
    }
}
