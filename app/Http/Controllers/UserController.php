<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();

        if ($request->filled('search'))
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");

        if ($request->role) {
            $q->where('role', $request->role);
        }

        if ($request->filled('campus_id')) {
            $q->where('campus_id', $request->campus_id);
        }

        $users = $q->latest()->paginate(20);
        $roles = Role::pluck('name', 'id');
        $campuses = \App\Models\Campus::active()->get();

        return $this->withOrg('users.index', compact('users', 'roles', 'campuses'));
    }

    public function create(): View
    {
        $roles = Role::pluck('name', 'id');
        $campuses = \App\Models\Campus::active()->get();
        return $this->withOrg('users.create', compact('roles', 'campuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'required|exists:roles,name',
            'campus_id'=> 'nullable|exists:campuses,id',
            'parent_id' => 'nullable|exists:users,id',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'phone'     => $validated['phone'],
            'role'      => $validated['role'],
            'campus_id'=> $validated['campus_id'],
            'parent_id'=> $validated['parent_id'],
            'is_active' => true,
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.show', $user)->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        $user->load(['campus', 'enrollments', 'documents', 'tickets', 'handledStudents']);
        return $this->withOrg('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::pluck('name', 'id');
        $campuses = \App\Models\Campus::active()->get();
        return $this->withOrg('users.edit', compact('user', 'roles', 'campuses'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => ['required', Rule::exists('roles','name')],
            'campus_id'=> 'nullable|exists:campuses,id',
            'is_active' => 'boolean',
        ]);

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.show', $user)->with('success', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('super_admin') && User::where('role','super_admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last super admin.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $password = $request->validate(['password' => 'required|min:8|confirmed']);
        $user->update(['password' => Hash::make($password['password'])]);
        return back()->with('success', 'Password reset successfully.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $users = User::where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'email', 'role', 'campus_id']);
        return response()->json($users);
    }
}
