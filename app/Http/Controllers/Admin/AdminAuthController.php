<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('admin.auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Default role for new registration is Customer
        $customerRole = Role::where('slug', 'customer')->first();
        $freePlan = \App\Models\SubscriptionPlan::where('slug', 'free-trial')->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => md5($validated['password']),
            'role_id' => $customerRole ? $customerRole->id : null,
            'status' => 'active',
            'guest_limit' => $freePlan ? $freePlan->guest_limit : 50,
        ]);

        // Give default free trial subscription
        if ($freePlan) {
            \App\Models\Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $freePlan->id,
                'amount' => $freePlan->price,
                'status' => 'active',
                'payment_method' => 'trial',
                'transaction_id' => 'TRIAL-' . rand(10000, 99999),
                'starts_at' => now(),
                'expires_at' => now()->addDays($freePlan->duration_days),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')->with('success', 'បង្កើតគណនីអតិថិជនជោគជ័យ! (Account registered successfully!)');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password === md5($credentials['password'])) {
            if ($user->status !== 'active') {
                return back()->withErrors([
                    'email' => 'គណនីរបស់អ្នកត្រូវបានផ្អាក (Account is inactive)',
                ])->onlyInput('email');
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user)->with('success', 'ចូលប្រព័ន្ធជោគជ័យ! (Login Successful)');
        }

        return back()->withErrors([
            'email' => 'អ៊ីមែល ឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ (Invalid email or password)',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'ចាកចេញពីប្រព័ន្ធជោគជ័យ (Logged out)');
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    }
}
