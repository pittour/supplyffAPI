<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        if (!auth()->user()->admin) {
            return response()->json(['error' => 'Permission denied'], 404);
        }
        $users = User::with('server')->where('admin', '!=', true)->get();
        $users->makeVisible('email');
        return $users;
    }

    public function ban(User $user)
    {

        if (!auth()->user()->admin) {
            return response()->json(['error' => 'Permission denied'], 404);
        }
        $user->classifieds()->delete();
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.'], 200);
    }
}
