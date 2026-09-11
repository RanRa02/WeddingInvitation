@extends('layouts.customer')

@section('title', 'Customer Dashboard')
@section('page_title', 'ផ្ទាំងគ្រប់គ្រងអតិថិជន (Customer Dashboard)')

@section('content')
<div class="row g-4 mb-4">
    <!-- Active Subscription Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger-subtle text-danger p-3 fs-3">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">ACTIVE SUBSCRIPTION</small>
                    <h4 class="fw-bold mb-0 text-dark">{{ $subscription->plan->name ?? 'Free Trial' }}</h4>
                    <small class="text-success fw-semibold"><i class="fa-solid fa-circle-check"></i> Status: Active</small>
                </div>
            </div>
            <hr class="my-3 text-muted opacity-25">
            <div class="d-flex justify-content-between text-muted fs-6 mb-2">
                <span>ចំនួនភ្ញៀវអនុញ្ញាត:</span>
                <strong class="text-dark">{{ number_format($guestLimit) }} នាក់</strong>
            </div>
            <a href="{{ route('customer.subscriptions.plans') }}" class="btn btn-outline-danger btn-sm rounded-pill mt-auto">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Upgrade Subscription Plan
            </a>
        </div>
    </div>

    <!-- Wedding Status Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary-subtle text-primary p-3 fs-3">
                    <i class="fa-solid fa-rings-wedding"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">WEDDING DETAILS</small>
                    <h4 class="fw-bold mb-0 text-dark">{{ $wedding ? ($wedding->groom_name . ' & ' . $wedding->bride_name) : 'មិនទាន់បង្កើត' }}</h4>
                    <small class="text-muted"><i class="fa-solid fa-calendar-days me-1"></i> {{ $wedding && $wedding->event_date ? $wedding->event_date->format('d M Y') : 'N/A' }}</small>
                </div>
            </div>
            <hr class="my-3 text-muted opacity-25">
            @if($wedding)
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Theme: {{ strtoupper($wedding->theme_template) }}</span>
                    <a href="{{ route('w.show', $wedding->slug) }}" target="_blank" class="btn btn-sm btn-link text-decoration-none">
                        <i class="fa-solid fa-eye me-1"></i> View Invitation
                    </a>
                </div>
            @else
                <a href="{{ route('customer.wedding.create') }}" class="btn btn-primary btn-sm rounded-pill mt-auto">
                    <i class="fa-solid fa-plus me-1"></i> Create Wedding Event
                </a>
            @endif
        </div>
    </div>

    <!-- Guests Progress Card -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning-subtle text-warning p-3 fs-3">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">GUEST USAGE</small>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($guestCount) }} / {{ number_format($guestLimit) }}</h4>
                    <small class="text-muted">ភ្ញៀវអញ្ជើញរៀបចំរួចរាល់</small>
                </div>
            </div>
            <hr class="my-3 text-muted opacity-25">
            @php $usagePercent = min(100, round(($guestCount / max(1, $guestLimit)) * 100)); @endphp
            <div class="progress rounded-pill mb-2" style="height: 10px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $usagePercent }}%;"></div>
            </div>
            <div class="d-flex justify-content-between small text-muted">
                <span>{{ $usagePercent }}% Used</span>
                <a href="{{ route('customer.guests.index') }}" class="text-decoration-none fw-bold">Manage Guests &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Onboarding Quick Action Cards -->
<div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-check text-danger me-2"></i> ជំហានរៀបចំធៀបការរបស់អ្នក (Wedding Setup Steps)</h5>
    
    <div class="row g-3">
        <div class="col-md-4">
            <div class="p-3 rounded-4 border bg-light h-100">
                <span class="badge bg-danger mb-2">Step 1</span>
                <h6 class="fw-bold">1. ជ្រើសរើស Plan & ទូទាត់</h6>
                <p class="small text-muted mb-3">ជ្រើសរើសកញ្ចប់សេវាដើម្បីទទួលបានចំនួនភ្ញៀវ និងទម្រង់ធៀបការដែលអ្នកពេញចិត្ត។</p>
                <a href="{{ route('customer.subscriptions.plans') }}" class="btn btn-sm btn-outline-danger rounded-pill">ជ្រើសរើសកញ្ចប់ &rarr;</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 rounded-4 border bg-light h-100">
                <span class="badge bg-primary mb-2">Step 2</span>
                <h6 class="fw-bold">2. បញ្ចូលព័ត៌មានកូនប្រុស កូនស្រី</h6>
                <p class="small text-muted mb-3">បញ្ចូលឈ្មោះកូនប្រុស កូនស្រី មាតាបិតា កាលបរិច្ឆេទ និងទីតាំងពិធីសារ។</p>
                <a href="{{ route('customer.wedding.create') }}" class="btn btn-sm btn-outline-primary rounded-pill">បញ្ចូលព័ត៌មាន &rarr;</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 rounded-4 border bg-light h-100">
                <span class="badge bg-success mb-2">Step 3</span>
                <h6 class="fw-bold">3. ជ្រើសរើសទម្រង់ធៀបការ (Theme)</h6>
                <p class="small text-muted mb-3">ជ្រើសរើសម៉ូដធៀបការស្អាតៗដូចជា Married Classic, Sapphire ឬ Ruby Theme។</p>
                <a href="{{ route('customer.wedding.template') }}" class="btn btn-sm btn-outline-success rounded-pill">ជ្រើសរើស Theme &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
