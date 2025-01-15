<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,',
            'birthday' => 'nullable|date',
            'about_me' => 'nullable|string|max:1000',
        ]);

        User::where('id', $user->id)->update([
            'name' => $validated['name'],
            'birthday' => $validated['birthday'],
            'about_me' => $validated['about_me'],
        ]);

        return redirect()
            ->route('profile.show', $validated['name'])
            ->with('success', 'Profile updated successfully');
    }
}