<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Role;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $guestQuery = Guest::query();
        if (!$isAdmin) {
            $guestQuery->where('user_id', $user->id);
        }

        $totalUsers = User::count();
        $totalRoles = Role::count();

        $totalGuests = (clone $guestQuery)->count();
        $attendingGuests = (clone $guestQuery)->where('attendance', 'attending')->count();
        $pendingGuests = (clone $guestQuery)->where('attendance', 'pending')->count();
        $declinedGuests = (clone $guestQuery)->where('attendance', 'declined')->count();
        
        $groomGuests = (clone $guestQuery)->where('side', 'groom')->count();
        $brideGuests = (clone $guestQuery)->where('side', 'bride')->count();
        $bothGuests = (clone $guestQuery)->where('side', 'both')->count();

        $recentGuests = (clone $guestQuery)->latest()->take(6)->get();
        $recentUsers = User::with('role')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRoles',
            'totalGuests',
            'attendingGuests',
            'pendingGuests',
            'declinedGuests',
            'groomGuests',
            'brideGuests',
            'bothGuests',
            'recentGuests',
            'recentUsers',
            'isAdmin'
        ));
    }
}
