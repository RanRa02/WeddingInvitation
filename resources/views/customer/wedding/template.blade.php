@extends('layouts.customer')

@section('title', __('app.wedding_builder_templates'))
@section('page_title', __('app.theme_templates_title'))

@push('css')
<style>
    /* ==========================================================================
       Bootstrap 5 Modern Minimalist Card Gallery (Categorized by Subscription)
       ========================================================================== */
    .template-section-header {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 26px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
    }

    /* Subscription Status Banner */
    .user-plan-banner {
        background: linear-gradient(135deg, #f8fafc, #edf2f7);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 20px;
    }

    /* Search Box Wrapper */
    .template-search-wrapper {
        position: relative;
        min-width: 260px;
    }

    .template-search-wrapper input {
        padding-left: 38px !important;
        padding-right: 16px !important;
        height: 40px;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        background-color: #ffffff;
        font-size: 13px;
        transition: all 0.2s ease;
        box-shadow: none;
    }

    .template-search-wrapper input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
    }

    .template-search-wrapper .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        font-size: 14px;
    }

    /* Plan Filter Buttons */
    .plan-filter-btn {
        appearance: none;
        -webkit-appearance: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        outline: none;
    }

    .plan-filter-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .plan-filter-btn.active {
        background: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    }

    .plan-filter-btn.active i {
        color: #ffffff !important;
    }

    /* Style Filter Buttons */
    .style-filter-btn {
        appearance: none;
        -webkit-appearance: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
    }

    .style-filter-btn:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .style-filter-btn.active {
        background: #1e293b !important;
        border-color: #1e293b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(30, 41, 59, 0.2);
    }

    .style-filter-btn.active i {
        color: #ffffff !important;
    }

    /* Card Image Container & Overlaid Floating Badges */
    .card-img-container {
        height: 260px;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
        cursor: pointer;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        transition: transform 0.35s ease;
        display: block;
    }

    .card:hover .card-img-container img {
        transform: scale(1.05);
    }

    .badge-plan-float {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 5;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        width: auto;
    }

    .badge-status-float {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 5;
    }

    /* Template Card Aesthetics & Active Selection */
    .template-card {
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
        border: 2px solid transparent !important;
        position: relative;
        background: #ffffff;
    }

    .template-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1) !important;
    }

    .template-card.is-active {
        border: 2.5px solid #0d6efd !important;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.18), 0 12px 28px rgba(13, 110, 253, 0.15) !important;
    }

    .template-card.is-active[data-theme="married"] {
        border-color: #0f5132 !important;
        box-shadow: 0 0 0 4px rgba(15, 81, 50, 0.18), 0 12px 28px rgba(15, 81, 50, 0.15) !important;
    }

    .template-card.is-active[data-theme="golden"] {
        border-color: #b8860b !important;
        box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.18), 0 12px 28px rgba(184, 134, 11, 0.15) !important;
    }

    .template-card.is-active[data-theme="ruby"],
    .template-card.is-active[data-theme="lotus"],
    .template-card.is-active[data-theme="romantic"] {
        border-color: #c2185b !important;
        box-shadow: 0 0 0 4px rgba(194, 24, 91, 0.18), 0 12px 28px rgba(194, 24, 91, 0.15) !important;
    }

    .template-card.is-active[data-theme="lavender"] {
        border-color: #6f42c1 !important;
        box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.18), 0 12px 28px rgba(111, 66, 193, 0.15) !important;
    }

    .template-card.is-active[data-theme="vintage"] {
        border-color: #795548 !important;
        box-shadow: 0 0 0 4px rgba(121, 85, 72, 0.18), 0 12px 28px rgba(121, 85, 72, 0.15) !important;
    }

    .active-badge-top {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: transparent;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
        transition: all 0.2s ease;
    }

    .template-card.is-active .active-badge-top {
        background: #0d6efd;
        color: #ffffff;
    }
    .template-card.is-active[data-theme="married"] .active-badge-top {
        background: #0f5132;
        color: #ffffff;
    }
    .template-card.is-active[data-theme="golden"] .active-badge-top {
        background: #b8860b;
        color: #ffffff;
    }
    .template-card.is-active[data-theme="ruby"] .active-badge-top,
    .template-card.is-active[data-theme="lotus"] .active-badge-top,
    .template-card.is-active[data-theme="romantic"] .active-badge-top {
        background: #c2185b;
        color: #ffffff;
    }
    .template-card.is-active[data-theme="lavender"] .active-badge-top {
        background: #6f42c1;
        color: #ffffff;
    }
    .template-card.is-active[data-theme="vintage"] .active-badge-top {
        background: #795548;
        color: #ffffff;
    }

    /* Locked Card State */
    .template-card.is-locked {
        opacity: 0.95;
    }
    .template-card.is-locked .card-img-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.15);
        pointer-events: none;
    }

    /* Floating Bottom Dock */
    .floating-bottom-dock {
        position: sticky;
        bottom: 20px;
        z-index: 100;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(16px);
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        padding: 12px 24px;
        transition: all 0.3s ease;
    }

    /* Modal Device Screen */
    .preview-modal-dialog {
        max-width: 1250px;
        width: 95%;
        margin: 1.25rem auto;
    }

    .preview-modal-content {
        height: 90vh;
        max-height: 920px;
        display: flex;
        flex-direction: column;
        border-radius: 24px;
    }

    .preview-modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
        background: #090d16;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .device-screen-container {
        transition: all 0.35s ease;
        margin: 0 auto;
        background: #fff;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .view-mobile {
        width: 390px;
        height: 750px;
        max-height: 80vh;
        border: 12px solid #1e293b;
        border-radius: 44px;
        overflow: hidden;
    }

    .view-tablet {
        width: 768px;
        height: 750px;
        max-height: 80vh;
        border: 10px solid #1e293b;
        border-radius: 32px;
        overflow: hidden;
    }

    .view-desktop {
        width: 100%;
        height: 750px;
        max-height: 80vh;
        border: 6px solid #1e293b;
        border-radius: 16px;
        overflow: hidden;
    }
</style>
@endpush

@php
    $userTier = $userTier ?? \App\Http\Controllers\Customer\WeddingController::getUserPlanTier($user);
    $templates = $templates ?? \App\Http\Controllers\Customer\WeddingController::getTemplatesCatalog();
    
    // Calculate how many templates are dynamically unlocked for this user
    $unlockedCount = 0;
    foreach ($templates as $tpl) {
        if (\App\Http\Controllers\Customer\WeddingController::isTemplateUnlockedForUser($user, $tpl['id'])) {
            $unlockedCount++;
        }
    }
@endphp

@section('content')
<div class="container-fluid p-0">

    <!-- 1. Header Banner & User Subscription Status -->
    <div class="template-section-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 48px; height: 48px; font-size: 20px; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ __('app.theme_templates_title') }}</h4>
                    <p class="text-muted small mb-0 mt-1">
                        {{ __('app.for_wedding_of') }} <strong class="text-primary">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</strong>
                    </p>
                </div>
            </div>

            <!-- Stepper Progress Breadcrumbs -->
            <div class="d-none d-lg-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted small">
                    <span class="badge bg-success rounded-circle p-1"><i class="fas fa-check" style="font-size: 9px;"></i></span>
                    <span>{{ __('app.step_subscription') }}</span>
                </div>
                <i class="fas fa-arrow-right text-muted small opacity-50"></i>
                <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted small">
                    <span class="badge bg-success rounded-circle p-1"><i class="fas fa-check" style="font-size: 9px;"></i></span>
                    <span>{{ __('app.step_wedding_info') }}</span>
                </div>
                <i class="fas fa-arrow-right text-muted small opacity-50"></i>
                <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary text-white small shadow-sm">
                    <span class="badge bg-white text-primary rounded-circle p-1 fw-bold" style="font-size: 10px; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                    <span class="fw-bold">{{ __('app.step_choose_template') }}</span>
                </div>
                <i class="fas fa-arrow-right text-muted small opacity-50"></i>
                <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted small opacity-75">
                    <span class="badge bg-secondary rounded-circle p-1" style="font-size: 10px; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;">4</span>
                    <span>{{ __('app.step_guest_list') }}</span>
                </div>
            </div>
        </div>

        <!-- User Active Subscription Plan Callout Bar -->
        <div class="user-plan-banner d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-size: 18px;">
                    <i class="fas fa-crown text-warning"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">{{ __('app.your_current_plan') }}:</span>
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <span>{{ $currentPlan->name ?? __('app.plan_free_trial') }}</span>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 font-monospace" style="font-size: 11px;">
                            <i class="fas fa-unlock-alt me-1"></i> {{ __('app.unlocked_templates_count', ['count' => $unlockedCount, 'total' => count($templates)]) }}
                        </span>
                    </h6>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.subscriptions.plans') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                    <i class="fas fa-arrow-up-right-dots me-1"></i> {{ __('app.view_plans') }}
                </a>
            </div>
        </div>

        <!-- Filter by Plan Tiers Bar & Search Box -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 border-top">
            <div class="d-flex flex-wrap align-items-center gap-2" id="planFilterPills">
                <button type="button" class="plan-filter-btn active" onclick="filterByPlan('all', this)">
                    <i class="fas fa-border-all text-primary"></i>
                    <span>{{ __('app.filter_all_plans') }} ({{ count($templates) }})</span>
                </button>
                <button type="button" class="plan-filter-btn" onclick="filterByPlan('free-trial', this)">
                    <i class="fas fa-gift text-secondary"></i>
                    <span>{{ __('app.plan_free_trial') }} (2)</span>
                </button>
                <button type="button" class="plan-filter-btn" onclick="filterByPlan('silver', this)">
                    <i class="fas fa-award text-info"></i>
                    <span>{{ __('app.plan_silver') }} (3)</span>
                </button>
                <button type="button" class="plan-filter-btn" onclick="filterByPlan('gold-premium', this)">
                    <i class="fas fa-crown text-warning"></i>
                    <span>{{ __('app.plan_gold_premium') }} (2)</span>
                </button>
                <button type="button" class="plan-filter-btn" onclick="filterByPlan('diamond-vip', this)">
                    <i class="fas fa-gem text-primary"></i>
                    <span>{{ __('app.plan_diamond_vip') }} (2)</span>
                </button>
            </div>

            <div class="template-search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="templateSearch" class="form-control" placeholder="{{ __('app.search_template_placeholder') }}" onkeyup="searchTemplates()">
            </div>
        </div>

        <!-- Secondary Filter: Filter by Style Tags -->
        <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-2">
            <span class="text-muted small fw-bold me-1 d-inline-flex align-items-center gap-1">
                <i class="fas fa-palette text-secondary"></i> {{ __('app.filter_by_style') }}:
            </span>
            <button type="button" class="style-filter-btn active" onclick="filterByStyle('all', this)">{{ __('app.filter_all') }}</button>
            <button type="button" class="style-filter-btn" onclick="filterByStyle('khmer', this)"><i class="fas fa-gem text-success"></i> {{ __('app.filter_khmer') }}</button>
            <button type="button" class="style-filter-btn" onclick="filterByStyle('luxury', this)"><i class="fas fa-crown text-warning"></i> {{ __('app.filter_luxury') }}</button>
            <button type="button" class="style-filter-btn" onclick="filterByStyle('modern', this)"><i class="fas fa-star text-primary"></i> {{ __('app.filter_modern') }}</button>
            <button type="button" class="style-filter-btn" onclick="filterByStyle('romantic', this)"><i class="fas fa-heart text-danger"></i> {{ __('app.filter_romantic') }}</button>
        </div>
    </div>

    <!-- 2. Responsive 3 Cards per Row Grid -->
    <form action="{{ route('customer.wedding.template.set') }}" method="POST" id="templateForm">
        @csrf

        <div class="row g-4 mb-4" id="templateGridRow">
            @foreach($templates as $tpl)
                @php
                    $isSelected = ($wedding->theme_template === $tpl['id']);
                    $isUnlocked = \App\Http\Controllers\Customer\WeddingController::isTemplateUnlockedForUser($user, $tpl['id']);
                    $tplTitle = __($tpl['title_key']);
                    $tplBadge = __($tpl['badge_key']);
                    $tplDesc = __($tpl['desc_key']);
                    $planName = __($tpl['plan_name_key']);
                @endphp
                <div class="col-12 col-md-6 col-lg-4 template-col-item" 
                     data-theme="{{ $tpl['id'] }}" 
                     data-plan="{{ $tpl['plan_group'] }}"
                     data-style="{{ $tpl['filter_group'] }}" 
                     data-title="{{ strtolower($tplTitle . ' ' . $tplBadge . ' ' . $planName . ' ' . $tplDesc) }}"
                     data-unlocked="{{ $isUnlocked ? '1' : '0' }}">
                    
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden template-card {{ $isSelected ? 'is-active' : '' }} {{ !$isUnlocked ? 'is-locked' : '' }}" 
                         id="card_{{ $tpl['id'] }}"
                         onclick="handleCardClick('{{ $tpl['id'] }}', {{ $isUnlocked ? 'true' : 'false' }}, '{{ addslashes($tplTitle) }}', '{{ addslashes($planName) }}', '{{ asset($tpl['image']) }}')">
                        
                        <!-- Top Image Container with Overlaid Floating Badges -->
                        <div class="card-img-container" onclick="openPreviewModal('{{ $tpl['id'] }}', '{{ addslashes($tplTitle) }}'); event.stopPropagation();">
                            
                            <!-- Left Float: Subscription Tier Badge -->
                            <span class="badge {{ $tpl['plan_badge_bg'] }} badge-plan-float">
                                <i class="{{ $tpl['plan_icon'] }}"></i>
                                <span>{{ $planName }}</span>
                            </span>

                            <!-- Right Float: Active Selection Checkmark or Lock Badge -->
                            <div class="badge-status-float">
                                @if($isUnlocked)
                                    <div class="active-badge-top" id="indicator_{{ $tpl['id'] }}">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @else
                                    <span class="badge bg-dark bg-opacity-90 text-warning px-2.5 py-1.5 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="font-size: 11px;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @endif
                            </div>

                            <img src="{{ asset($tpl['image']) }}" class="card-img-top" alt="{{ $tplTitle }}" loading="lazy">
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column justify-content-between p-3 p-md-4">
                            <div>
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                    <h5 class="card-title fw-bold text-dark mb-0">{{ $tplTitle }}</h5>
                                    <span class="badge {{ $tpl['badge_bg'] }} px-2 py-1 rounded-pill" style="font-size: 10.5px;">
                                        {{ $tplBadge }}
                                    </span>
                                </div>

                                <p class="text-{{ $tpl['theme_color'] }} small fw-semibold mb-2">
                                    <i class="fas fa-shield-check me-1"></i> {{ __('app.included_in_plan', ['plan' => $planName]) }} &bull; #{{ $tpl['num'] }}
                                </p>

                                <p class="card-text text-muted small mb-0" style="line-height: 1.55;">
                                    {{ $tplDesc }}
                                </p>
                            </div>

                            <!-- Hidden Radio Input -->
                            <input type="radio" class="d-none" name="template" id="tpl_{{ $tpl['id'] }}" value="{{ $tpl['id'] }}" {{ $isSelected ? 'checked' : '' }} onchange="onRadioChange()">

                            <!-- Bottom Row Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                                <span class="text-muted small"><i class="fas fa-mobile-alt me-1"></i> {{ __('app.portrait_orientation') }}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" onclick="event.stopPropagation(); openPreviewModal('{{ $tpl['id'] }}', '{{ addslashes($tplTitle) }}')">
                                        <i class="fas fa-eye text-primary me-1"></i> {{ __('app.preview_template') }}
                                    </button>

                                    @if($isUnlocked)
                                        <button type="button" class="btn btn-sm {{ $isSelected ? 'btn-' . $tpl['theme_color'] . ' text-white' : 'btn-outline-' . $tpl['theme_color'] }} rounded-pill px-3 fw-bold" id="btn_select_{{ $tpl['id'] }}" onclick="event.stopPropagation(); selectTheme('{{ $tpl['id'] }}')">
                                            <i class="fas {{ $isSelected ? 'fa-check-circle' : 'fa-circle-check' }} me-1"></i>
                                            <span id="btn_text_{{ $tpl['id'] }}">{{ $isSelected ? __('app.currently_active') : __('app.select_template') }}</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-bold" onclick="event.stopPropagation(); showUpgradeModal('{{ addslashes($tplTitle) }}', '{{ addslashes($planName) }}', '{{ asset($tpl['image']) }}', '{{ $tpl['id'] }}')">
                                            <i class="fas fa-lock me-1 text-warning"></i>
                                            <span>{{ __('app.upgrade_required') }}</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        <!-- 3. Floating Bottom Action Dock -->
        <div class="floating-bottom-dock mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-dark shadow-sm" style="width: 44px; height: 44px;">
                        <i class="fas fa-palette text-primary"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ __('app.selected_template_label') }}</span>
                        <h6 class="fw-bold mb-0 text-dark" id="currentSelectedTitle">
                            @php
                                $selectedTpl = $templates[$wedding->theme_template] ?? $templates['married'];
                                $selTitle = __($selectedTpl['title_key']);
                                $selBadge = __($selectedTpl['badge_key']);
                            @endphp
                            <i class="fas fa-check-circle text-success me-1"></i> {{ $selTitle }} ({{ $selBadge }})
                        </h6>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('w.show', $wedding->slug) }}" target="_blank" class="btn btn-outline-dark rounded-pill px-4 fw-semibold">
                        <i class="fas fa-external-link-alt me-1"></i> {{ __('app.view_live_invitation') }}
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow">
                        <i class="fas fa-check-circle me-1"></i> {{ __('app.save_and_continue_guests') }} &rarr;
                    </button>
                </div>
            </div>
        </div>

    </form>

</div>

<!-- 4. Interactive Device Preview Modal -->
<div class="modal fade" id="themePreviewModal" tabindex="-1" aria-labelledby="themePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog preview-modal-dialog modal-dialog-centered">
        <div class="modal-content preview-modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-dark text-white border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-eye text-warning"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold mb-0" id="themePreviewModalLabel">{{ __('app.live_preview_title') }}</h6>
                        <small class="text-white-50" id="previewThemeSub">{{ __('app.live_interactive_preview') }}</small>
                    </div>
                </div>

                <!-- Device Switcher Controls -->
                <div class="d-none d-md-flex align-items-center bg-black bg-opacity-40 rounded-pill p-1 border border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 active" id="btnViewMobile" onclick="switchPreviewDevice('mobile')">
                        <i class="fas fa-mobile-alt me-1"></i> Mobile
                    </button>
                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3" id="btnViewTablet" onclick="switchPreviewDevice('tablet')">
                        <i class="fas fa-tablet-alt me-1"></i> Tablet
                    </button>
                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3" id="btnViewDesktop" onclick="switchPreviewDevice('desktop')">
                        <i class="fas fa-desktop me-1"></i> Desktop
                    </button>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold" id="btnApplyInModal" onclick="applyCurrentModalTheme()">
                        <i class="fas fa-check me-1"></i> {{ __('app.apply_this_template') }}
                    </button>
                    <a href="#" target="_blank" id="previewExternalLink" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="fas fa-external-link-alt me-1"></i> {{ __('app.open_in_new_tab') }}
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body preview-modal-body text-center position-relative">
                <div id="deviceScreen" class="device-screen-container view-mobile">
                    <iframe id="previewIframe" src="about:blank" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5. VIP Upgrade Plan Modal -->
<div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-labelledby="upgradePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-20 d-flex align-items-center justify-content-center text-warning shadow-sm" style="width: 48px; height: 48px; font-size: 22px;">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="upgradePlanModalLabel">{{ __('app.upgrade_plan_modal_title') }}</h5>
                        <small class="text-white-50" id="upgradeModalSub">{{ __('app.upgrade_required') }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 text-center">
                <img id="upgradeModalImg" src="" alt="Theme Preview" class="rounded-3 shadow-sm mb-3" style="max-height: 180px; width: auto; object-fit: cover;">
                <h5 class="fw-bold text-dark mb-1" id="upgradeModalThemeTitle"></h5>
                <p class="text-muted small mb-3" id="upgradeModalDesc"></p>

                <div class="p-3 bg-light rounded-3 border mb-3 text-start small">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>{{ __('app.unlocked') }} VIP Template design & animations</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>High guest capacity & custom RSVP management</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Custom background music & KHQR payment support</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('customer.subscriptions.plans') }}" class="btn btn-primary rounded-pill py-2 fw-bold shadow">
                        <i class="fas fa-crown me-1"></i> {{ __('app.upgrade_now') }}
                    </a>
                    <button type="button" class="btn btn-light rounded-pill py-2 fw-semibold border" id="btnPreviewLockedInModal">
                        <i class="fas fa-eye text-primary me-1"></i> {{ __('app.preview_template') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const baseUrl = "{{ route('w.show', $wedding->slug) }}";
    let activeModalTheme = 'married';
    let currentPlanFilter = 'all';
    let currentStyleFilter = 'all';

    const langCurrentlyActive = "{{ __('app.currently_active') }}";
    const langSelectTemplate = "{{ __('app.select_template') }}";
    const langPreviewTitle = "{{ __('app.live_preview_title') }}";
    const langUpgradeModalDesc = "{{ __('app.upgrade_plan_modal_desc') }}";

    const themeTitles = {
        'married': { title: "{{ __('app.tpl_married_title') }} ({{ __('app.tpl_married_badge') }})", icon: 'fa-gem text-success', color: 'success', tier: 1 },
        'sapphire': { title: "{{ __('app.tpl_sapphire_title') }} ({{ __('app.tpl_sapphire_badge') }})", icon: 'fa-crown text-primary', color: 'primary', tier: 1 },
        'lotus': { title: "{{ __('app.tpl_lotus_title') }} ({{ __('app.tpl_lotus_badge') }})", icon: 'fa-spa text-danger', color: 'danger', tier: 2 },
        'ruby': { title: "{{ __('app.tpl_ruby_title') }} ({{ __('app.tpl_ruby_badge') }})", icon: 'fa-heart text-danger', color: 'danger', tier: 2 },
        'romantic': { title: "{{ __('app.tpl_romantic_title') }} ({{ __('app.tpl_romantic_badge') }})", icon: 'fa-heart text-danger', color: 'danger', tier: 2 },
        'golden': { title: "{{ __('app.tpl_golden_title') }} ({{ __('app.tpl_golden_badge') }})", icon: 'fa-crown text-warning', color: 'warning', tier: 3 },
        'diamond': { title: "{{ __('app.tpl_diamond_title') }} ({{ __('app.tpl_diamond_badge') }})", icon: 'fa-gem text-info', color: 'info', tier: 3 },
        'lavender': { title: "{{ __('app.tpl_lavender_title') }} ({{ __('app.tpl_lavender_badge') }})", icon: 'fa-moon text-primary', color: 'primary', tier: 4 },
        'vintage': { title: "{{ __('app.tpl_vintage_title') }} ({{ __('app.tpl_vintage_badge') }})", icon: 'fa-feather text-dark', color: 'dark', tier: 4 }
    };

    function handleCardClick(themeKey, isUnlocked, title, planName, imgSrc) {
        if (isUnlocked) {
            selectTheme(themeKey);
        } else {
            showUpgradeModal(title, planName, imgSrc, themeKey);
        }
    }

    function selectTheme(themeName) {
        if (!themeTitles[themeName]) return;
        const radio = document.getElementById('tpl_' + themeName);
        if (radio) {
            radio.checked = true;
            onRadioChange();
        }
    }

    function onRadioChange() {
        const selected = document.querySelector('input[name="template"]:checked');
        if (!selected) return;

        const val = selected.value;

        // 1. Reset all card active classes
        document.querySelectorAll('.template-card').forEach(card => {
            card.classList.remove('is-active');
        });

        // 2. Reset buttons
        Object.keys(themeTitles).forEach(t => {
            const btn = document.getElementById('btn_select_' + t);
            const textSpan = document.getElementById('btn_text_' + t);
            const info = themeTitles[t];

            if (btn) {
                btn.className = 'btn btn-sm btn-outline-' + info.color + ' rounded-pill px-3 fw-bold';
            }
            if (textSpan) {
                textSpan.innerText = langSelectTemplate;
            }
        });

        // 3. Highlight selected theme
        const activeCard = document.getElementById('card_' + val);
        const activeBtn = document.getElementById('btn_select_' + val);
        const activeTextSpan = document.getElementById('btn_text_' + val);
        const activeInfo = themeTitles[val];

        if (activeCard) activeCard.classList.add('is-active');
        if (activeBtn && activeInfo) {
            activeBtn.className = 'btn btn-sm btn-' + activeInfo.color + ' text-white rounded-pill px-3 fw-bold';
        }
        if (activeTextSpan) {
            activeTextSpan.innerText = langCurrentlyActive;
        }

        if (activeInfo) {
            document.getElementById('currentSelectedTitle').innerHTML = '<i class="fas ' + activeInfo.icon + ' me-1"></i> ' + activeInfo.title;
        }
    }

    function openPreviewModal(themeKey, themeTitle) {
        activeModalTheme = themeKey;
        const modalEl = document.getElementById('themePreviewModal');
        const modal = new bootstrap.Modal(modalEl);
        
        const previewUrl = baseUrl + '?preview_theme=' + themeKey;
        
        document.getElementById('themePreviewModalLabel').innerText = langPreviewTitle + ' - ' + themeTitle;
        document.getElementById('previewExternalLink').href = previewUrl;
        
        const iframe = document.getElementById('previewIframe');
        iframe.src = previewUrl;

        modal.show();
    }

    function showUpgradeModal(title, planName, imgSrc, themeKey) {
        document.getElementById('upgradeModalThemeTitle').innerText = title;
        document.getElementById('upgradeModalDesc').innerText = langUpgradeModalDesc.replace(':plan', planName);
        document.getElementById('upgradeModalImg').src = imgSrc;
        
        const btnPreview = document.getElementById('btnPreviewLockedInModal');
        btnPreview.onclick = function() {
            const upModal = bootstrap.Modal.getInstance(document.getElementById('upgradePlanModal'));
            if (upModal) upModal.hide();
            openPreviewModal(themeKey, title);
        };

        const modal = new bootstrap.Modal(document.getElementById('upgradePlanModal'));
        modal.show();
    }

    function applyCurrentModalTheme() {
        selectTheme(activeModalTheme);
        const modalEl = document.getElementById('themePreviewModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    function switchPreviewDevice(device) {
        const screen = document.getElementById('deviceScreen');
        const btnMobile = document.getElementById('btnViewMobile');
        const btnTablet = document.getElementById('btnViewTablet');
        const btnDesktop = document.getElementById('btnViewDesktop');

        btnMobile.classList.remove('active', 'bg-primary');
        btnTablet.classList.remove('active', 'bg-primary');
        btnDesktop.classList.remove('active', 'bg-primary');

        screen.classList.remove('view-mobile', 'view-tablet', 'view-desktop');

        if (device === 'mobile') {
            screen.classList.add('view-mobile');
            btnMobile.classList.add('active', 'bg-primary');
        } else if (device === 'tablet') {
            screen.classList.add('view-tablet');
            btnTablet.classList.add('active', 'bg-primary');
        } else if (device === 'desktop') {
            screen.classList.add('view-desktop');
            btnDesktop.classList.add('active', 'bg-primary');
        }
    }

    function filterByPlan(plan, element) {
        currentPlanFilter = plan;
        document.querySelectorAll('#planFilterPills .plan-filter-btn').forEach(pill => pill.classList.remove('active'));
        if (element) element.classList.add('active');
        applyCombinedFilters();
    }

    function filterByStyle(style, element) {
        currentStyleFilter = style;
        document.querySelectorAll('.style-filter-btn').forEach(pill => pill.classList.remove('active'));
        if (element) element.classList.add('active');
        applyCombinedFilters();
    }

    function applyCombinedFilters() {
        const query = document.getElementById('templateSearch').value.toLowerCase().trim();
        const items = document.querySelectorAll('.template-col-item');

        items.forEach(item => {
            const planGroup = item.getAttribute('data-plan');
            const styleGroup = item.getAttribute('data-style');
            const title = item.getAttribute('data-title');

            const matchPlan = (currentPlanFilter === 'all' || planGroup === currentPlanFilter);
            const matchStyle = (currentStyleFilter === 'all' || styleGroup === currentStyleFilter);
            const matchSearch = (query === '' || title.includes(query));

            if (matchPlan && matchStyle && matchSearch) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function searchTemplates() {
        applyCombinedFilters();
    }
</script>
@endpush
