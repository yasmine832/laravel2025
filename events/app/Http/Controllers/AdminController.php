<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('id', '!=', Auth::id());

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('search') . '%');
            });
        }

        // Filter by role (admin or user)
        if ($request->filled('role')) {
            $query->where('is_admin', $request->input('role') === 'admin');
        }

        $users = $query->get();

        return view('admin.index', compact('users'));
    }
    public function toggleAdmin(User $user)
    {
        if ($user->id !== Auth::id()) {
            $user->is_admin = !$user->is_admin;
            $user->save();
        }
        return back()->with('success', 'User admin status updated successfully');
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $validated['is_admin'] ?? false,
        ]);

        return redirect()->route('admin.index')->with('success', 'User created successfully');
    }
}