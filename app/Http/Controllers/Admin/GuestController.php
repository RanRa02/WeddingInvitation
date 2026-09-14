<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GuestDatatable;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function index(GuestDatatable $dataTable, Request $request)
    {
        $user = auth()->user();
        if (!$user->canViewPage('admin.guests.index')) {
            abort(403, 'លោកអ្នកគ្មានសិទ្ធិចូលមើលទំព័រនេះទេ (Unauthorized access)');
        }

        $isAdmin = $user->isAdmin();
        $canCreate = $user->canCreateOnPage('admin.guests.index');
        $canEdit = $user->canEditOnPage('admin.guests.index');
        $canDelete = $user->canDeleteOnPage('admin.guests.index');

        $search = $request->query('search');
        $side = $request->query('side');
        $attendance = $request->query('attendance');
        $filterUserId = $request->query('user_id');

        $baseQuery = Guest::with('user');
        if (!$isAdmin) {
            $baseQuery->where('user_id', $user->id);
        } elseif ($filterUserId) {
            $baseQuery->where('user_id', $filterUserId);
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'attending' => (clone $baseQuery)->where('attendance', 'attending')->count(),
            'pending' => (clone $baseQuery)->where('attendance', 'pending')->count(),
            'declined' => (clone $baseQuery)->where('attendance', 'declined')->count(),
            'groom' => (clone $baseQuery)->where('side', 'groom')->count(),
            'bride' => (clone $baseQuery)->where('side', 'bride')->count(),
        ];

        return $dataTable->render('admin.guests.index', compact('stats', 'isAdmin', 'canCreate', 'canEdit', 'canDelete', 'search', 'side', 'attendance', 'filterUserId'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->canCreateOnPage('admin.guests.index')) {
            abort(403, __('app.unauthorized_action'));
        }

        if ($user->hasReachedGuestLimit()) {
            return redirect()->route('admin.guests.index')->with('error', __('app.guest_limit_reached_with_count', ['limit' => $user->guest_limit]));
        }

        return view('admin.guests.create');
    }

    public function edit(Guest $guest)
    {
        $user = auth()->user();
        if (!$user->canEditOnPage('admin.guests.index') || (!$user->isAdmin() && $guest->user_id !== $user->id)) {
            abort(403, __('app.unauthorized_action'));
        }

        return view('admin.guests.edit', compact('guest'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->canCreateOnPage('admin.guests.index')) {
            abort(403, __('app.unauthorized_action'));
        }

        if ($user->hasReachedGuestLimit()) {
            return redirect()->route('admin.guests.index')->with('error', __('app.guest_limit_reached_with_count', ['limit' => $user->guest_limit]));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'side' => 'required|in:groom,bride,both',
            'table_number' => 'nullable|string|max:50',
            'attendance' => 'required|in:pending,attending,declined',
            'companions' => 'required|integer|min:1|max:20',
            'wishes' => 'nullable|string',
            'gift_amount' => 'nullable|string|max:100',
            'note' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        $validated['invitation_code'] = 'INV-' . strtoupper(Str::random(6));

        Guest::create($validated);

        if ($request->input('action') === 'save_and_new') {
            return redirect()->route('admin.guests.create')->with('success', __('app.guest_added_successfully'));
        }

        return redirect()->route('admin.guests.index')->with('success', __('app.guest_added_successfully'));
    }

    public function update(Request $request, Guest $guest)
    {
        $user = auth()->user();
        if (!$user->canEditOnPage('admin.guests.index') || (!$user->isAdmin() && $guest->user_id !== $user->id)) {
            abort(403, __('app.unauthorized_action'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'side' => 'required|in:groom,bride,both',
            'table_number' => 'nullable|string|max:50',
            'attendance' => 'required|in:pending,attending,declined',
            'companions' => 'required|integer|min:1|max:20',
            'wishes' => 'nullable|string',
            'gift_amount' => 'nullable|string|max:100',
            'note' => 'nullable|string',
        ]);

        $guest->update($validated);

        return redirect()->route('admin.guests.index')->with('success', __('app.guest_updated_successfully'));
    }

    public function destroy(Guest $guest)
    {
        $user = auth()->user();
        if (!$user->canDeleteOnPage('admin.guests.index') || (!$user->isAdmin() && $guest->user_id !== $user->id)) {
            abort(403, __('app.unauthorized_action'));
        }

        $guest->delete();

        return redirect()->route('admin.guests.index')->with('success', __('app.guest_deleted_successfully'));
    }
}
