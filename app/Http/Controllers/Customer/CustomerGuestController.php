<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\DataTables\Customer\CustomerGuestDatatable;

class CustomerGuestController extends Controller
{
    public function index(CustomerGuestDatatable $dataTable)
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        $guestLimit = $subscription ? $subscription->plan->guest_limit : ($user->guest_limit ?? 50);
        $guestCount = $user->guests()->count();

        return $dataTable->render('customer.guests.index', compact('user', 'guestLimit', 'guestCount'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasReachedGuestLimit()) {
            return back()->with('error', __('app.guest_limit_reached'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'side' => 'required|in:groom,bride,both',
            'table_number' => 'nullable|string|max:50',
            'companions' => 'nullable|integer|min:0',
            'note' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        $validated['invitation_code'] = 'INV-' . strtoupper(Str::random(6));
        $validated['attendance'] = 'pending';

        Guest::create($validated);

        return back()->with('success', __('app.guest_added_successfully'));
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'side' => 'required|in:groom,bride,both',
            'table_number' => 'nullable|string|max:50',
            'attendance' => 'nullable|string',
            'companions' => 'nullable|integer|min:0',
            'gift_amount' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $guest->update($validated);

        return back()->with('success', __('app.guest_updated_successfully'));
    }

    public function destroy($id)
    {
        $guest = Guest::where('user_id', Auth::id())->findOrFail($id);
        $guest->delete();

        return back()->with('success', __('app.guest_deleted_successfully'));
    }

    public function send()
    {
        $user = Auth::user();
        $wedding = $user->wedding;
        $guests = $user->guests()->latest()->get();

        return view('customer.invitations.send', compact('user', 'wedding', 'guests'));
    }

    public function reports()
    {
        $user = Auth::user();
        $guests = $user->guests()->get();

        $totalGuests = $guests->count();
        $attendingCount = $guests->where('attendance', 'attending')->count();
        $declinedCount = $guests->where('attendance', 'declined')->count();
        $pendingCount = $guests->where('attendance', 'pending')->count();
        $totalCompanions = $guests->where('attendance', 'attending')->sum('companions');

        return view('customer.reports.index', compact(
            'user',
            'guests',
            'totalGuests',
            'attendingCount',
            'declinedCount',
            'pendingCount',
            'totalCompanions'
        ));
    }
}
