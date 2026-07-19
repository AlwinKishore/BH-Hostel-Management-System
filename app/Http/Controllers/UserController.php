<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $academic_years = \App\Models\AcademicYear::all();
        return view('admin.users.create', compact('academic_years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'academic_year_id' => ['nullable', 'exists:academic_years,id'],
            'is_active' => ['boolean'],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'academic_year_id' => $request->academic_year_id,
            'is_active' => $request->has('is_active', true),
        ]);

        return redirect()->route('users.index')->with('success', 'New system user registered successfully.');
    }

    public function edit(User $user)
    {
        $academic_years = \App\Models\AcademicYear::all();
        return view('admin.users.edit', compact('user', 'academic_years'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'academic_year_id' => ['nullable', 'exists:academic_years,id'],
            'is_active' => ['boolean'],
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'academic_year_id' => $request->academic_year_id,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User profile updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Authentication error: You cannot terminate your own active session.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User access revoked and deleted.');
    }
}
