<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Wedding;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('price', 'asc')->get();
        $sampleWeddings = Wedding::where('is_published', true)->take(3)->get();

        return view('landing', compact('plans', 'sampleWeddings'));
    }
}
