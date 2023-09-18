<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;


class UserController extends Controller
{
    public function show(User $user)
    {   
        return Inertia::render('Users/Show', [
            'userDetails' => $user->load(['course', 'form'])
        ]);
    }

    public function approveUser(User $user)
    {
        $user->update([
            'is_active' => true
        ]);
    
        return to_route('users.index');
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'is_active' => false
        ]);
        return to_route('users.index');
    }
}