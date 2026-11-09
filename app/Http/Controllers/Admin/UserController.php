<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with('roles');

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($data['role']);

        ActivityLog::log('user_created', "Created user '{$user->name}' with role '{$data['role']}'", $user);

        return redirect()->route('admin.users.index')->with('success', 'User account created.');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_active = $request->boolean('is_active');

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles([$data['role']]);

        ActivityLog::log('user_updated', "Updated staff account for '{$user->name}'", $user);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::log('user_deleted', "Deleted user account '{$name}'");

        return redirect()->route('admin.users.index')->with('success', "User '{$name}' deleted.");
    }
}
