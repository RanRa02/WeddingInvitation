<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WeddingController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $wedding = $user->wedding ?? new Wedding();

        return view('customer.wedding.create', compact('user', 'wedding'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $wedding = $user->wedding;

        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_name_en' => 'nullable|string|max:255',
            'bride_name' => 'required|string|max:255',
            'bride_name_en' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'bride_parents' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'lunar_date' => 'nullable|string|max:255',
            'morning_time' => 'nullable|string|max:255',
            'evening_time' => 'nullable|string|max:255',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_location_url' => 'nullable|url',
            'music_url' => 'nullable|string|max:1000',
            'music_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac,wma|max:20480',
            'preset_music' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bank_qr_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverName = 'cover_' . time() . '_' . rand(100, 999) . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->move(public_path('uploads/weddings'), $coverName);
            $validated['cover_image'] = 'uploads/weddings/' . $coverName;
        }

        if ($request->hasFile('bank_qr_image')) {
            $qrFile = $request->file('bank_qr_image');
            $qrName = 'qr_' . time() . '_' . rand(100, 999) . '.' . $qrFile->getClientOriginalExtension();
            $qrFile->move(public_path('uploads/qr'), $qrName);
            $validated['bank_qr_image'] = 'uploads/qr/' . $qrName;
        }

        if ($request->hasFile('music_file')) {
            $musicFile = $request->file('music_file');
            $musicName = 'song_' . time() . '_' . rand(100, 999) . '.' . $musicFile->getClientOriginalExtension();
            $musicFile->move(public_path('uploads/audio'), $musicName);
            $validated['music_url'] = 'uploads/audio/' . $musicName;
        } elseif ($request->filled('preset_music') && !$request->filled('music_url')) {
            $validated['music_url'] = $request->input('preset_music');
        }

        if (!$wedding) {
            $slug = Str::slug($validated['groom_name'] . '-' . $validated['bride_name'] . '-wedding');
            // Ensure unique slug
            if (Wedding::where('slug', $slug)->exists()) {
                $slug .= '-' . rand(100, 999);
            }

            $wedding = Wedding::create(array_merge($validated, [
                'user_id' => $user->id,
                'slug' => $slug,
                'theme_template' => 'married',
                'is_published' => true,
            ]));
        } else {
            $wedding->update($validated);
        }

        return redirect()->route('customer.wedding.template')
            ->with('success', __('app.wedding_saved_successfully'));
    }

    public static function getTemplatesCatalog()
    {
        return [
            'married' => [
                'id' => 'married',
                'title_key' => 'app.tpl_married_title',
                'num' => '01',
                'badge_key' => 'app.tpl_married_badge',
                'badge_bg' => 'bg-success bg-gradient',
                'desc_key' => 'app.tpl_married_desc',
                'image' => 'images/templates/married_canva.jpg',
                'theme_color' => 'success',
                'filter_group' => 'khmer',
                'plan_group' => 'free-trial',
                'min_plan_tier' => 1,
                'plan_name_key' => 'app.plan_free_trial',
                'plan_name' => 'Free Trial',
                'plan_badge_bg' => 'bg-secondary bg-gradient text-white',
                'plan_icon' => 'fas fa-gift',
            ],
            'sapphire' => [
                'id' => 'sapphire',
                'title_key' => 'app.tpl_sapphire_title',
                'num' => '04',
                'badge_key' => 'app.tpl_sapphire_badge',
                'badge_bg' => 'bg-primary bg-gradient',
                'desc_key' => 'app.tpl_sapphire_desc',
                'image' => 'images/templates/sapphire_canva.jpg',
                'theme_color' => 'primary',
                'filter_group' => 'modern',
                'plan_group' => 'free-trial',
                'min_plan_tier' => 1,
                'plan_name_key' => 'app.plan_free_trial',
                'plan_name' => 'Free Trial',
                'plan_badge_bg' => 'bg-secondary bg-gradient text-white',
                'plan_icon' => 'fas fa-gift',
            ],
            'lotus' => [
                'id' => 'lotus',
                'title_key' => 'app.tpl_lotus_title',
                'num' => '03',
                'badge_key' => 'app.tpl_lotus_badge',
                'badge_bg' => 'bg-danger bg-gradient',
                'desc_key' => 'app.tpl_lotus_desc',
                'image' => 'images/templates/lotus_canva.jpg',
                'theme_color' => 'danger',
                'filter_group' => 'romantic',
                'plan_group' => 'silver',
                'min_plan_tier' => 2,
                'plan_name_key' => 'app.plan_silver',
                'plan_name' => 'Silver Plan',
                'plan_badge_bg' => 'bg-info bg-gradient text-white',
                'plan_icon' => 'fas fa-award',
            ],
            'ruby' => [
                'id' => 'ruby',
                'title_key' => 'app.tpl_ruby_title',
                'num' => '05',
                'badge_key' => 'app.tpl_ruby_badge',
                'badge_bg' => 'bg-danger bg-gradient',
                'desc_key' => 'app.tpl_ruby_desc',
                'image' => 'images/templates/ruby_canva.jpg',
                'theme_color' => 'danger',
                'filter_group' => 'romantic',
                'plan_group' => 'silver',
                'min_plan_tier' => 2,
                'plan_name_key' => 'app.plan_silver',
                'plan_name' => 'Silver Plan',
                'plan_badge_bg' => 'bg-info bg-gradient text-white',
                'plan_icon' => 'fas fa-award',
            ],
            'romantic' => [
                'id' => 'romantic',
                'title_key' => 'app.tpl_romantic_title',
                'num' => '06',
                'badge_key' => 'app.tpl_romantic_badge',
                'badge_bg' => 'bg-danger bg-gradient',
                'desc_key' => 'app.tpl_romantic_desc',
                'image' => 'images/templates/romantic_canva.jpg',
                'theme_color' => 'danger',
                'filter_group' => 'romantic',
                'plan_group' => 'silver',
                'min_plan_tier' => 2,
                'plan_name_key' => 'app.plan_silver',
                'plan_name' => 'Silver Plan',
                'plan_badge_bg' => 'bg-info bg-gradient text-white',
                'plan_icon' => 'fas fa-award',
            ],
            'golden' => [
                'id' => 'golden',
                'title_key' => 'app.tpl_golden_title',
                'num' => '02',
                'badge_key' => 'app.tpl_golden_badge',
                'badge_bg' => 'bg-warning text-dark bg-gradient',
                'desc_key' => 'app.tpl_golden_desc',
                'image' => 'images/templates/golden_canva.jpg',
                'theme_color' => 'warning',
                'filter_group' => 'luxury',
                'plan_group' => 'gold-premium',
                'min_plan_tier' => 3,
                'plan_name_key' => 'app.plan_gold_premium',
                'plan_name' => 'Gold Premium',
                'plan_badge_bg' => 'bg-warning bg-gradient text-dark',
                'plan_icon' => 'fas fa-crown',
            ],
            'diamond' => [
                'id' => 'diamond',
                'title_key' => 'app.tpl_diamond_title',
                'num' => '07',
                'badge_key' => 'app.tpl_diamond_badge',
                'badge_bg' => 'bg-info text-dark bg-gradient',
                'desc_key' => 'app.tpl_diamond_desc',
                'image' => 'images/templates/diamond_canva.jpg',
                'theme_color' => 'info',
                'filter_group' => 'modern',
                'plan_group' => 'gold-premium',
                'min_plan_tier' => 3,
                'plan_name_key' => 'app.plan_gold_premium',
                'plan_name' => 'Gold Premium',
                'plan_badge_bg' => 'bg-warning bg-gradient text-dark',
                'plan_icon' => 'fas fa-crown',
            ],
            'lavender' => [
                'id' => 'lavender',
                'title_key' => 'app.tpl_lavender_title',
                'num' => '08',
                'badge_key' => 'app.tpl_lavender_badge',
                'badge_bg' => 'bg-primary bg-gradient',
                'desc_key' => 'app.tpl_lavender_desc',
                'image' => 'images/templates/lavender_canva.jpg',
                'theme_color' => 'primary',
                'filter_group' => 'romantic',
                'plan_group' => 'diamond-vip',
                'min_plan_tier' => 4,
                'plan_name_key' => 'app.plan_diamond_vip',
                'plan_name' => 'Diamond VIP',
                'plan_badge_bg' => 'bg-dark bg-gradient text-white border border-secondary',
                'plan_icon' => 'fas fa-gem',
            ],
            'vintage' => [
                'id' => 'vintage',
                'title_key' => 'app.tpl_vintage_title',
                'num' => '09',
                'badge_key' => 'app.tpl_vintage_badge',
                'badge_bg' => 'bg-dark bg-gradient text-white',
                'desc_key' => 'app.tpl_vintage_desc',
                'image' => 'images/templates/vintage_canva.jpg',
                'theme_color' => 'dark',
                'filter_group' => 'luxury',
                'plan_group' => 'diamond-vip',
                'min_plan_tier' => 4,
                'plan_name_key' => 'app.plan_diamond_vip',
                'plan_name' => 'Diamond VIP',
                'plan_badge_bg' => 'bg-dark bg-gradient text-white border border-secondary',
                'plan_icon' => 'fas fa-gem',
            ],
        ];
    }

    public static function getUserPlanTier($user)
    {
        if (!$user) {
            return 1;
        }

        if ($user->isAdmin()) {
            return 4; // Full VIP Access
        }

        $subscription = $user->activeSubscription;
        if (!$subscription || !$subscription->plan) {
            return 1; // Default Free Trial Tier
        }

        $slug = $subscription->plan->slug;
        return match ($slug) {
            'diamond-vip' => 4,
            'gold-premium' => 3,
            'silver' => 2,
            default => 1,
        };
    }

    public function template()
    {
        $user = Auth::user();
        $wedding = $user->wedding;

        if (!$wedding) {
            return redirect()->route('customer.wedding.create')
                ->with('warning', __('app.please_fill_wedding_first'));
        }

        $subscription = $user->activeSubscription;
        $currentPlan = $subscription ? $subscription->plan : null;
        $userTier = self::getUserPlanTier($user);
        $templates = self::getTemplatesCatalog();
        $plans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('price', 'asc')->get();

        return view('customer.wedding.template', compact(
            'user',
            'wedding',
            'subscription',
            'currentPlan',
            'userTier',
            'templates',
            'plans'
        ));
    }

    /**
     * Determine if a template is unlocked for the specified user based on dynamic subscription plans.
     */
    public static function isTemplateUnlockedForUser($user, string $templateId): bool
    {
        if (!$user) {
            return false;
        }
        if ($user->isAdmin()) {
            return true;
        }

        $subscription = $user->activeSubscription;
        if ($subscription && $subscription->plan) {
            return $subscription->plan->isTemplateAllowed($templateId);
        }

        // Default to Free Trial plan settings
        $freePlan = \App\Models\SubscriptionPlan::where('slug', 'free-trial')->first();
        if ($freePlan) {
            return $freePlan->isTemplateAllowed($templateId);
        }

        return in_array($templateId, ['married', 'sapphire']);
    }

    public function setTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|in:married,sapphire,ruby,golden,lotus,romantic,diamond,lavender,vintage',
        ]);

        $user = Auth::user();
        $wedding = $user->wedding;
        if (!$wedding) {
            return redirect()->route('customer.wedding.create')
                ->with('warning', __('app.please_fill_wedding_first'));
        }

        $templateId = $request->template;
        $isUnlocked = self::isTemplateUnlockedForUser($user, $templateId);

        if (!$isUnlocked) {
            $templates = self::getTemplatesCatalog();
            $selectedTemplate = $templates[$templateId] ?? null;
            $planName = $selectedTemplate ? __($selectedTemplate['plan_name_key']) : __('app.subscription_plans');

            return redirect()->route('customer.subscriptions.plans')
                ->with('warning', __('app.template_requires_plan', ['plan' => $planName]));
        }

        $wedding->update(['theme_template' => $templateId]);

        return redirect()->route('customer.guests.index')
            ->with('success', __('app.template_updated_successfully'));
    }

    public function showPublic($slug)
    {
        $wedding = Wedding::where('slug', $slug)->firstOrFail();
        
        // Pass guest code or guest name if provided in query string ?guest=...
        $guestQuery = request('guest', '');
        $guest = null;
        $guestName = $guestQuery;

        if ($guestQuery) {
            $foundGuest = \App\Models\Guest::where('invitation_code', $guestQuery)
                ->orWhere('name', $guestQuery)
                ->first();
            if ($foundGuest) {
                $guest = $foundGuest;
                $guestName = $guest->name;
            }
        }

        $availableThemes = ['married', 'sapphire', 'ruby', 'golden', 'lotus', 'romantic', 'diamond', 'lavender', 'vintage'];
        $previewTheme = request('preview_theme');
        $theme = in_array($previewTheme, $availableThemes) ? $previewTheme : $wedding->theme_template;
        if (!in_array($theme, $availableThemes)) {
            $theme = 'married';
        }

        $templateView = 'wedding-invitation.' . $theme;
        if (!view()->exists($templateView)) {
            $templateView = 'wedding-invitation.married';
        }

        return view($templateView, compact('wedding', 'guest', 'guestName'));
    }

    public function downloadIcs(Request $request)
    {
        $guestName = $request->query('guest', '');
        $title = "អាពាហ៍ពិពាហ៍ - Wedding Invitation";
        $description = "សូមអញ្ជើញ " . $guestName . " ចូលរួមពិធីសិរីមង្គលអាពាហ៍ពិពាហ៍";
        $location = "គេហដ្ឋាន";

        $icsContent = "BEGIN:VCALENDAR\r\n"
            . "VERSION:2.0\r\n"
            . "PRODID:-//Wedding Invitation//KM\r\n"
            . "CALSCALE:GREGORIAN\r\n"
            . "METHOD:PUBLISH\r\n"
            . "BEGIN:VEVENT\r\n"
            . "SUMMARY:{$title}\r\n"
            . "DESCRIPTION:{$description}\r\n"
            . "LOCATION:{$location}\r\n"
            . "DTSTART:20270411T073000Z\r\n"
            . "DTEND:20270411T210000Z\r\n"
            . "STATUS:CONFIRMED\r\n"
            . "SEQUENCE:0\r\n"
            . "END:VEVENT\r\n"
            . "END:VCALENDAR";

        return response($icsContent, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="wedding_event.ics"',
        ]);
    }
}
