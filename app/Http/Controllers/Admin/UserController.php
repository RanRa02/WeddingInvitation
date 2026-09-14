<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDatatable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserDatatable $dataTable, Request $request)
    {
        $search = $request->query('search');
        $roleId = $request->query('role_id');
        $roles = Role::all();

        return $dataTable->render('admin.users.index', compact('roles', 'search', 'roleId'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'guest_limit' => 'nullable|integer|min:1|max:100000',
        ]);

        $validated['guest_limit'] = $validated['guest_limit'] ?? 100;
        $validated['password'] = md5($validated['password']);

        User::create($validated);

        if ($request->input('action') === 'save_and_new') {
            return redirect()->route('admin.users.create')->with('success', __('app.user_created_successfully'));
        }

        return redirect()->route('admin.users.index')->with('success', __('app.user_created_successfully'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'guest_limit' => 'nullable|integer|min:1|max:100000',
        ]);

        $validated['guest_limit'] = $validated['guest_limit'] ?? 100;

        if (!empty($validated['password'])) {
            $validated['password'] = md5($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', __('app.user_updated_successfully'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', __('app.cannot_delete_logged_in_user'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('app.user_deleted_successfully'));
    }
}
