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
        $subscription = $user->activeSubscription;
        $wedding = $user->wedding;
        $guestCount = $user->guests()->count();
        $guestLimit = $subscription ? $subscription->plan->guest_limit : ($user->guest_limit ?? 50);
        $attendingCount = $user->guests()->where('attendance', 'attending')->count();
        $declinedCount = $user->guests()->where('attendance', 'declined')->count();

        return view('customer.dashboard.index', compact(
            'user',
            'subscription',
            'wedding',
            'guestCount',
            'guestLimit',
            'attendingCount',
            'declinedCount'
        ));
    }
}
