<?php

namespace App\Http\Controllers;

use App\Events\UserConfirmed;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show(User $user)
    {   
        return Inertia::render('Users/Show', [
            'userDetails' => $user->load(['course', 'form', 'roles'])
        ]);
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['admin', 'student'])->get();
        return Inertia::render('Users/Create', [
            'roles' => $roles
        ]);
    }

    public function showProfile()
    {
        $user = auth()->user();
        if($user->hasRole('admin')){
            // return redirect()->route('users.index');

            dd('route is not for admin');
        }
        return Inertia::render('Users/Profile', [
            'userDetails' => $user->load(['course', 'form'])
        ]);
    }

    public function changePassword(Request $request)
    {
        // dd(1);
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
        ]);
        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return to_route('users.profile');
        } 
        throw ValidationException::withMessages(['current_password' => 'Current password is incorrect.']);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => ['required', Rule::in(['adviser', 'faculty', 'panel'])], // Adjust the roles as needed
        ];
    
        // Validate the request data
        $request->validate($rules);
    
        // Generate a temporary password
        $temporaryPassword = \Str::random(8);
        $hashedPassword = \Hash::make($temporaryPassword);
    
        // Create a new user
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => $hashedPassword,
            'phone_number' => $request->phone,
            'is_active' => true,
        ]);
    
        // Assign the selected role
        $user->assignRole($request->role);
    
        if ($user) {
            UserCreated::dispatch($user, $temporaryPassword);
        }
    
        return to_route('users.index');
    }

    public function approveUser(User $user)
    {
        $user->update([
            'is_active' => true
        ]);

        if($user){
            UserConfirmed::dispatch($user);
        }
        
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
