<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.menu-settings.roles.index');
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Role::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        Role::create($validated);

        if ($request->input('action') === 'save_and_new') {
            return redirect()->route('admin.roles.create')->with('success', 'បង្កើតតួនាទីជោគជ័យ! (Role created successfully)');
        }

        return redirect()->route('admin.roles.index')->with('success', 'បង្កើតតួនាទីជោគជ័យ! (Role created successfully)');
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('success', 'កែប្រែតួនាទីជោគជ័យ! (Role updated successfully)');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->with('error', 'មិនអាចលុបតួនាទីនេះបានទេ ព្រោះមានអ្នកប្រើប្រាស់កំពុងកាន់តួនាទីនេះ! (Cannot delete role assigned to users)');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'លុបតួនាទីជោគជ័យ! (Role deleted successfully)');
    }
}
