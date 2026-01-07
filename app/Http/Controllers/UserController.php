<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display list user
     */
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show form create user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:developer,admin,staff',
        ]);

        // Admin TIDAK boleh membuat developer
        if (
            auth()->user()->isAdmin() &&
            $request->role === User::ROLE_DEVELOPER
        ) {
            abort(403, 'Admin tidak boleh membuat developer');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }
}
