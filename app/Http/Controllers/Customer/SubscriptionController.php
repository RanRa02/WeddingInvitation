<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('price', 'asc')->get();
        $user = Auth::user();
        $currentSubscription = $user->activeSubscription;

        return view('customer.subscription.plans', compact('plans', 'user', 'currentSubscription'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = Auth::user();

        // Expire any existing active subscriptions
        Subscription::where('user_id', $user->id)->update(['status' => 'expired']);

        // Create new active subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'active',
            'payment_method' => $request->payment_method,
            'transaction_id' => 'TXN-' . strtoupper($request->payment_method) . '-' . rand(100000, 999999),
            'starts_at' => now(),
            'expires_at' => now()->addDays($plan->duration_days),
        ]);

        // Update user guest limit from plan
        $user->update(['guest_limit' => $plan->guest_limit]);

        return redirect()->route('customer.wedding.create')
            ->with('success', __('app.subscription_activated_successfully'));
    }
}
