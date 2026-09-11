<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PlanDatatable;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index(PlanDatatable $dataTable)
    {
        $plans = SubscriptionPlan::latest()->get();
        return $dataTable->render('admin.plans.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'guest_limit' => 'required|integer|min:1',
            'duration_days' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'features' => 'nullable|string', // comma separated or lines
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['name']);
        if (SubscriptionPlan::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(100, 999);
        }

        // Convert features string to array
        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_map('trim', explode("\n", str_replace("\r", "", $validated['features'])));
        }

        SubscriptionPlan::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'guest_limit' => $validated['guest_limit'],
            'duration_days' => $validated['duration_days'],
            'description' => $validated['description'] ?? '',
            'features' => $featuresArray,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'បង្កើតកញ្ចប់សេវាជោគជ័យ! (Subscription plan created successfully)');
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'guest_limit' => 'required|integer|min:1',
            'duration_days' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_map('trim', explode("\n", str_replace("\r", "", $validated['features'])));
        }

        $plan->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'guest_limit' => $validated['guest_limit'],
            'duration_days' => $validated['duration_days'],
            'description' => $validated['description'] ?? '',
            'features' => $featuresArray,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'កែប្រែកញ្ចប់សេវាជោគជ័យ! (Subscription plan updated successfully)');
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'លុបកញ្ចប់សេវាជោគជ័យ! (Subscription plan deleted successfully)');
    }
}
