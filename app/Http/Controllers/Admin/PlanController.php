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
            'allowed_templates' => $request->input('allowed_templates', SubscriptionPlan::getDefaultTemplatesForSlug($slug)),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', __('app.plan_created_successfully'));
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
            'allowed_templates' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_map('trim', explode("\n", str_replace("\r", "", $validated['features'])));
        }

        $updateData = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'guest_limit' => $validated['guest_limit'],
            'duration_days' => $validated['duration_days'],
            'description' => $validated['description'] ?? '',
            'features' => $featuresArray,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->has('allowed_templates')) {
            $updateData['allowed_templates'] = $request->input('allowed_templates', []);
        }

        $plan->update($updateData);

        return redirect()->route('admin.plans.index')
            ->with('success', __('app.plan_updated_successfully'));
    }

    /**
     * Display the Plan-to-Template Assignment management view.
     */
    public function templatesIndex()
    {
        $plans = SubscriptionPlan::orderBy('price', 'asc')->get();
        $templates = \App\Http\Controllers\Customer\WeddingController::getTemplatesCatalog();

        return view('admin.plans.templates', compact('plans', 'templates'));
    }

    /**
     * Update allowed templates configuration for plans.
     */
    public function updateTemplates(Request $request)
    {
        // Case 1: Update single plan (via specific plan form)
        if ($request->filled('plan_id')) {
            $plan = SubscriptionPlan::findOrFail($request->input('plan_id'));
            $allowedTemplates = $request->input('allowed_templates', []);
            $plan->update([
                'allowed_templates' => is_array($allowedTemplates) ? $allowedTemplates : []
            ]);

            return redirect()->back()
                ->with('success', __('app.plan_templates_updated_for_plan', ['plan' => $plan->name]));
        }

        // Case 2: Batch update all plans from matrix form
        if ($request->has('plans') && is_array($request->input('plans'))) {
            foreach ($request->input('plans') as $planId => $data) {
                $plan = SubscriptionPlan::find($planId);
                if ($plan) {
                    $templates = isset($data['allowed_templates']) && is_array($data['allowed_templates']) 
                        ? $data['allowed_templates'] 
                        : [];
                    $plan->update(['allowed_templates' => $templates]);
                }
            }

            return redirect()->back()
                ->with('success', __('app.plan_templates_updated_successfully'));
        }

        return redirect()->back()->with('warning', __('app.no_changes_detected'));
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', __('app.plan_deleted_successfully'));
    }
}
