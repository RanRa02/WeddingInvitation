@extends('layouts.customer')

@section('title', __('app.dashboard'))
@section('page_title', __('app.customer_portal'))

@section('content')
<div class="container-fluid p-0">
    <!-- 1. Top Welcome Banner Card -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #1877f2, #0866ff);">
        <div class="card-body p-4 text-white position-relative" style="z-index: 2;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white text-primary fw-bold d-flex align-items-center justify-content-center shadow" style="width: 56px; height: 56px; font-size: 22px;">
                        <i class="fas fa-heart text-danger"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-white">
                            @if($wedding)
                                {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
                            @else
                                {{ __('app.customer_portal') }}
                            @endif
                        </h4>
                        <p class="mb-0 text-white-50 small">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name ?? 'Customer' }} &bull; 
                            <i class="fas fa-envelope me-1"></i> {{ auth()->user()->email ?? '' }} &bull; 
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 ms-1">
                                <i class="fas fa-crown text-warning me-1"></i> {{ $subscription->plan->name ?? 'Free Trial' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if($wedding)
                        <a href="{{ route('w.show', $wedding->slug) }}" target="_blank" class="btn btn-light text-primary fw-semibold rounded-pill px-3 shadow-sm">
                            <i class="fas fa-eye me-1 text-primary"></i> {{ __('app.view_invitation') }}
                        </a>
                        <a href="{{ route('customer.wedding.create') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-3 shadow-sm" style="background: #ffc107; border: none;">
                            <i class="fas fa-pen-nib me-1"></i> {{ __('app.edit') }}
                        </a>
                    @else
                        <a href="{{ route('customer.wedding.create') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm" style="background: #ffc107; border: none;">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('បញ្ចូលព័ត៌មានមង្គលការ (Create Wedding)') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <!-- Decorative Background Shapes -->
        <div class="position-absolute end-0 top-0 bottom-0 opacity-10 d-none d-md-block" style="pointer-events: none;">
            <i class="fas fa-rings-wedding" style="font-size: 200px; transform: translate(30px, -20px);"></i>
        </div>
    </div>

    <!-- 2. Row 1: Top 5 Solid Gradient Stat Block Cards -->
    <div class="row g-3 mb-4">
        <!-- Block 1: Purple / Indigo (Guest Limit & Usage) -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden h-100" style="background: linear-gradient(135deg, #7367f0, #9e95f5);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="small text-white-50 fw-bold">{{ __('app.guest_limit') }}</span>
                        <h3 class="fw-bold mb-0 mt-1" style="font-size: 24px;">{{ number_format($guestCount) }} <span class="fs-6 text-white-50 fw-normal">/ {{ number_format($guestLimit) }}</span></h3>
                    </div>
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                @php $usagePercent = min(100, round(($guestCount / max(1, $guestLimit)) * 100)); @endphp
                <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50 align-items-center">
                    <span>{{ $usagePercent }}% {{ __('Used') }}</span>
                    <a href="{{ route('customer.guests.index') }}" class="text-white fw-bold text-decoration-none small">{{ __('app.guest_list') }} &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Block 2: Cyan / Sky Blue (Attending) -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden h-100" style="background: linear-gradient(135deg, #00cfe8, #48dae3);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="small text-white-50 fw-bold">{{ __('app.attending_guests') }}</span>
                        <h3 class="fw-bold mb-0 mt-1" style="font-size: 24px;">{{ number_format($attendingCount) }}</h3>
                    </div>
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                    <span>{{ __('app.attending') }}</span>
                    <span class="text-white fw-bold">{{ $attendingCount }} {{ __('នាក់') }}</span>
                </div>
            </div>
        </div>

        <!-- Block 3: Emerald Green (Pending) -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden h-100" style="background: linear-gradient(135deg, #28c76f, #52e093);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="small text-white-50 fw-bold">{{ __('app.pending_rsvp') }}</span>
                        <h3 class="fw-bold mb-0 mt-1" style="font-size: 24px;">{{ number_format($pendingCount) }}</h3>
                    </div>
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                    <span>{{ __('app.pending') }}</span>
                    <span class="text-white fw-bold">{{ $pendingCount }} {{ __('នាក់') }}</span>
                </div>
            </div>
        </div>

        <!-- Block 4: Rose / Coral (Declined) -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden h-100" style="background: linear-gradient(135deg, #ea5455, #f57f80);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="small text-white-50 fw-bold">{{ __('app.declined') }}</span>
                        <h3 class="fw-bold mb-0 mt-1" style="font-size: 24px;">{{ number_format($declinedCount) }}</h3>
                    </div>
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                    <span>{{ __('app.declined') }}</span>
                    <span class="text-white fw-bold">{{ $declinedCount }} {{ __('នាក់') }}</span>
                </div>
            </div>
        </div>

        <!-- Block 5: Gold / Amber (Subscription Plan) -->
        <div class="col-12 col-sm-6 col-xl">
            <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden h-100" style="background: linear-gradient(135deg, #ff9f43, #ffb976);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="small text-white-50 fw-bold">{{ __('app.subscription_plans') }}</span>
                        <h3 class="fw-bold mb-0 mt-1" style="font-size: 20px;">{{ $subscription->plan->name ?? 'Free Trial' }}</h3>
                    </div>
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50 align-items-center">
                    <span><i class="fas fa-check-circle text-white me-1"></i> {{ __('Active') }}</span>
                    <a href="{{ route('customer.subscriptions.plans') }}" class="text-white fw-bold text-decoration-none small">{{ __('Upgrade') }} &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Middle Section: Wedding Setup Steps & Invitation Overview -->
    <div class="row g-4 mb-4">
        <!-- Left: Wedding Setup Steps (Wizard) -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-tasks text-primary me-2"></i> {{ __('ជំហានរៀបចំធៀបការរបស់អ្នក (Setup Roadmap)') }}
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold">
                        @php
                            $completedSteps = ($subscription ? 1 : 0) + ($wedding ? 2 : 0) + ($guestCount > 0 ? 1 : 0);
                        @endphp
                        {{ $completedSteps }} / 4 {{ __('Completed') }}
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- Step 1: Subscription -->
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between gap-3 {{ $subscription ? 'bg-light border-success-subtle' : 'bg-white' }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 38px; height: 38px; background: {{ $subscription ? '#28c76f' : '#7367f0' }}; font-size: 14px;">
                                @if($subscription) <i class="fas fa-check"></i> @else 1 @endif
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ __('1. ជ្រើសរើសកញ្ចប់សេវាកម្ម (Subscription Plan)') }}</h6>
                                <p class="text-muted small mb-0">{{ __('កញ្ចប់សកម្មបច្ចុប្បន្ន:') }} <strong>{{ $subscription->plan->name ?? 'Free Trial' }}</strong> ({{ number_format($guestLimit) }} នាក់)</p>
                            </div>
                        </div>
                        <a href="{{ route('customer.subscriptions.plans') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            {{ $subscription ? __('ប្តូរកញ្ចប់') : __('ជ្រើសរើស') }}
                        </a>
                    </div>

                    <!-- Step 2: Wedding Details -->
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between gap-3 {{ $wedding ? 'bg-light border-success-subtle' : 'bg-white' }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 38px; height: 38px; background: {{ $wedding ? '#28c76f' : '#ff9f43' }}; font-size: 14px;">
                                @if($wedding) <i class="fas fa-check"></i> @else 2 @endif
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ __('2. បញ្ចូលព័ត៌មានមង្គលការ (Wedding Information)') }}</h6>
                                <p class="text-muted small mb-0">
                                    @if($wedding)
                                        {{ $wedding->groom_name }} & {{ $wedding->bride_name }} &bull; {{ $wedding->event_date ? $wedding->event_date->format('d/m/Y') : '' }}
                                    @else
                                        {{ __('បញ្ចូលឈ្មោះកូនប្រុស កូនស្រី មាតាបិតា ពេលវេលា និងទីតាំងពិធី') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('customer.wedding.create') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 text-dark">
                            {{ $wedding ? __('កែប្រែ') : __('បញ្ចូល') }}
                        </a>
                    </div>

                    <!-- Step 3: Template Theme -->
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between gap-3 {{ ($wedding && $wedding->theme_template) ? 'bg-light border-success-subtle' : 'bg-white' }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 38px; height: 38px; background: {{ ($wedding && $wedding->theme_template) ? '#28c76f' : '#00cfe8' }}; font-size: 14px;">
                                @if($wedding && $wedding->theme_template) <i class="fas fa-check"></i> @else 3 @endif
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ __('3. ជ្រើសរើសទម្រង់ធៀបការ (Theme Template)') }}</h6>
                                <p class="text-muted small mb-0">
                                    @if($wedding)
                                        {{ __('ទម្រង់បច្ចុប្បន្ន:') }} <span class="badge bg-primary rounded-pill px-2">{{ strtoupper($wedding->theme_template ?? 'Married') }}</span>
                                    @else
                                        {{ __('ជ្រើសរើសទម្រង់ Married Classic, Sapphire ឬ Ruby Theme') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('customer.wedding.template') }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                            {{ __('ជ្រើសរើស') }}
                        </a>
                    </div>

                    <!-- Step 4: Add Guests & Send -->
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between gap-3 {{ $guestCount > 0 ? 'bg-light border-success-subtle' : 'bg-white' }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 38px; height: 38px; background: {{ $guestCount > 0 ? '#28c76f' : '#ea5455' }}; font-size: 14px;">
                                @if($guestCount > 0) <i class="fas fa-check"></i> @else 4 @endif
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ __('4. បន្ថែមបញ្ជីភ្ញៀវ & ផ្ញើសំបុត្រ (Guest List & Sending)') }}</h6>
                                <p class="text-muted small mb-0">{{ __('បានបញ្ចូល:') }} <strong>{{ number_format($guestCount) }}</strong> {{ __('នាក់') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            {{ __('គ្រប់គ្រង') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Wedding Invitation Card & Public Link Sharing -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fas fa-envelope-open-text text-danger me-2"></i> {{ __('លីងធៀបការសាធារណៈ (Public Invitation)') }}
                </h5>

                @if($wedding)
                    @php $publicUrl = route('w.show', $wedding->slug); @endphp
                    <div class="rounded-4 p-3 mb-3 text-center position-relative" style="background: #f8f9fa; border: 1px dashed #ced4da;">
                        @if($wedding->cover_image)
                            <img src="{{ asset($wedding->cover_image) }}" alt="Cover" class="rounded-3 img-fluid mb-3 shadow-sm" style="max-height: 160px; object-fit: cover; width: 100%;">
                        @else
                            <div class="py-4 text-muted">
                                <i class="fas fa-image fa-3x mb-2 text-secondary opacity-50"></i>
                                <p class="small mb-0">{{ __('មិនទាន់មានរូបភាព Cover') }}</p>
                            </div>
                        @endif

                        <h6 class="fw-bold text-dark mb-1">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h6>
                        <p class="text-muted small mb-2"><i class="fas fa-calendar-day text-danger me-1"></i> {{ $wedding->event_date ? $wedding->event_date->format('l, d F Y') : 'N/A' }}</p>

                        <div class="input-group mb-2">
                            <input type="text" class="form-control form-control-sm bg-white" id="publicWeddingUrl" value="{{ $publicUrl }}" readonly>
                            <button class="btn btn-primary btn-sm px-3" type="button" onclick="copyPublicUrl()">
                                <i class="fas fa-copy me-1"></i> {{ __('Copy') }}
                            </button>
                        </div>
                        <small id="copySuccessMsg" class="text-success fw-bold d-none"><i class="fas fa-check me-1"></i> {{ __('បាន Copy លីងជោគជ័យ!') }}</small>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ $publicUrl }}" target="_blank" class="btn btn-primary rounded-pill fw-semibold shadow-sm">
                            <i class="fas fa-external-link-alt me-1"></i> {{ __('មើលធៀបការផ្ទាល់ (View Public Site)') }}
                        </a>
                        <a href="{{ route('customer.invitations.send') }}" class="btn btn-warning text-white rounded-pill fw-semibold shadow-sm" style="background: #ff9f43; border: none;">
                            <i class="fas fa-paper-plane me-1"></i> {{ __('ផ្ញើសំបុត្រទៅកាន់ភ្ញៀវ (Send Invitations)') }}
                        </a>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-heart text-muted opacity-50 fa-2x"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">{{ __('មិនទាន់បានបញ្ចូលព័ត៌មានមង្គលការ') }}</h6>
                        <p class="small text-muted mb-4">{{ __('សូមបង្កើត និងបញ្ចូលព័ត៌មានមង្គលការ ដើម្បីទទួលបានលីងធៀបការ') }}</p>
                        <a href="{{ route('customer.wedding.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('បង្កើតធៀបការឥឡូវនេះ') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Bottom Section: Recent Guests Table -->
    <div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
        <div class="p-3 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="dreams-card-title mb-0">
                    <i class="fas fa-user-friends text-primary me-2"></i> {{ __('ភ្ញៀវដែលបានបញ្ចូលថ្មីៗ (Recent Guests)') }}
                </h5>
            </div>
            <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                {{ __('មើលទាំងអស់ (View All)') }} &rarr;
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-gold-header align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">{{ __('app.no') }}</th>
                        <th>{{ __('app.guest_name') }}</th>
                        <th class="text-center">{{ __('app.side') }}</th>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th class="text-center">{{ __('app.companions') }}</th>
                        <th class="text-center">{{ __('app.rsvp') }}</th>
                        <th class="text-end" style="width: 100px;">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentGuests as $index => $guest)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <strong class="text-dark">{{ $guest->name }}</strong>
                                @if($guest->phone)
                                    <small class="text-muted d-block"><i class="fas fa-phone-alt me-1"></i> {{ $guest->phone }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($guest->side === 'groom')
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(24, 119, 242, 0.12); color: #1877f2;">{{ __('app.groom_side') }}</span>
                                @elseif($guest->side === 'bride')
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(234, 84, 85, 0.12); color: #ea5455;">{{ __('app.bride_side') }}</span>
                                @else
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(255, 159, 67, 0.12); color: #ff9f43;">{{ __('app.both_sides') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(108, 117, 125, 0.12); color: #495057;">
                                    {{ $guest->table_number ? 'តុ ' . $guest->table_number : '-' }}
                                </span>
                            </td>
                            <td class="text-center font-monospace fw-bold text-dark">
                                {{ $guest->companions ?? 0 }}
                            </td>
                            <td class="text-center">
                                @if($guest->attendance === 'attending')
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(40, 199, 111, 0.15); color: #1e874b; border: 1px solid rgba(40, 199, 111, 0.3);">
                                        <i class="fas fa-check-circle me-1"></i> {{ __('app.attending') }}
                                    </span>
                                @elseif($guest->attendance === 'declined')
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(234, 84, 85, 0.15); color: #d63031; border: 1px solid rgba(234, 84, 85, 0.3);">
                                        <i class="fas fa-times-circle me-1"></i> {{ __('app.declined') }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(255, 159, 67, 0.15); color: #d35400; border: 1px solid rgba(255, 159, 67, 0.3);">
                                        <i class="fas fa-clock me-1"></i> {{ __('app.pending') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-light rounded-circle shadow-sm" title="{{ __('app.edit') }}">
                                    <i class="fas fa-pen-nib text-secondary"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-users-slash fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                                {{ __('មិនទាន់មានទិន្នន័យភ្ញៀវនៅឡើយទេ (No Guests Found)') }}
                                <div class="mt-2">
                                    <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        <i class="fas fa-user-plus me-1"></i> {{ __('បន្ថែមភ្ញៀវដំបូង (Add First Guest)') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyPublicUrl() {
        var copyText = document.getElementById("publicWeddingUrl");
        if (copyText) {
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value).then(function() {
                var msg = document.getElementById("copySuccessMsg");
                if (msg) {
                    msg.classList.remove("d-none");
                    setTimeout(function() {
                        msg.classList.add("d-none");
                    }, 3000);
                }
            });
        }
    }
</script>
@endpush
