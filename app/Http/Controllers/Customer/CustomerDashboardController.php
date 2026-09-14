<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscription = $user ? $user->activeSubscription : null;
        $wedding = $user ? $user->wedding : null;
        $guestCount = $user ? $user->guests()->count() : 0;
        $guestLimit = $subscription ? $subscription->plan->guest_limit : ($user->guest_limit ?? 50);
        $attendingCount = $user ? $user->guests()->where('attendance', 'attending')->count() : 0;
        $declinedCount = $user ? $user->guests()->where('attendance', 'declined')->count() : 0;
        $pendingCount = $user ? $user->guests()->where('attendance', 'pending')->count() : 0;
        $recentGuests = $user ? $user->guests()->latest()->take(5)->get() : collect();

        return view('customer.dashboard.index', compact(
            'user',
            'subscription',
            'wedding',
            'guestCount',
            'guestLimit',
            'attendingCount',
            'declinedCount',
            'pendingCount',
            'recentGuests'
        ));
    }
}
