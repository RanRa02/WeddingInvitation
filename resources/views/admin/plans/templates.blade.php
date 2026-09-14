@extends('layouts.admin')

@section('title', __('app.plan_templates_management'))
@section('page_title', __('app.plan_templates_management'))

@push('css')
<style>
    /* Plan Template Assignment Matrix Styles */
    .admin-tpl-hero {
        background: linear-gradient(135deg, #1877f2 0%, #0d6efd 50%, #0866ff 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 24px 28px;
        box-shadow: 0 8px 24px rgba(24, 119, 242, 0.18);
        margin-bottom: 24px;
    }

    .form-switch-lg .form-check-input {
        width: 2.85rem;
        height: 1.45rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-switch-lg .form-check-input:checked {
        background-color: #1877f2;
        border-color: #1877f2;
    }

    /* Matrix Table Styles */
    .matrix-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #eef2f6;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .matrix-table {
        margin-bottom: 0;
    }

    .matrix-table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 16px 14px;
        color: #1e293b;
        vertical-align: middle;
    }

    .matrix-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .matrix-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .matrix-table tbody td {
        padding: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
    }

    .plan-col-header {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
    }

    .plan-badge-count {
        font-size: 11px;
        font-weight: 700;
    }

    .btn-col-toggle {
        font-size: 10.5px;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Hero Header Banner -->
    <div class="admin-tpl-hero d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-white text-primary fw-bold px-2.5 py-1 rounded-pill">
                    <i class="fas fa-layer-group me-1"></i> {{ __('app.admin_management') }}
                </span>
            </div>
            <h3 class="fw-bold mb-1 text-white">{{ __('app.plan_templates_management') }}</h3>
            <p class="mb-0 text-white-50 small">{{ __('app.plan_templates_desc') }}</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.plans.index') }}" class="btn btn-light bg-white text-dark font-semibold rounded-pill px-3 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> {{ __('app.back_to_plans') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="fas fa-check-circle fs-5 text-success"></i>
            <div><strong>{{ session('success') }}</strong></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="fas fa-exclamation-triangle fs-5 text-warning"></i>
            <div><strong>{{ session('warning') }}</strong></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Matrix Overview Direct Card -->
    <div class="matrix-card mb-4">
        <!-- Card Header Info -->
        <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">
                    <i class="fas fa-table-cells text-primary me-2"></i> {{ __('app.matrix_view') }}
                </h5>
                <p class="text-muted small mb-0">{{ __('app.matrix_overview_subtitle') }}</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="selectAllAllPlans()">
                    <i class="fas fa-check-double me-1"></i> {{ __('app.select_all_templates') }}
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="deselectAllAllPlans()">
                    <i class="fas fa-times me-1"></i> {{ __('app.deselect_all_templates') }}
                </button>
            </div>
        </div>

        <!-- Form for Batch Matrix Update -->
        <form action="{{ route('admin.plans.templates.update') }}" method="POST" id="matrixForm">
            @csrf

            <div class="table-responsive">
                <table class="table matrix-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="min-width: 260px;">{{ __('app.template_name') }}</th>
                            <th class="text-center" style="width: 140px;">{{ __('app.style') }}</th>
                            @foreach($plans as $plan)
                                @php
                                    $allowedTpls = is_array($plan->allowed_templates) ? $plan->allowed_templates : \App\Models\SubscriptionPlan::getDefaultTemplatesForSlug($plan->slug);
                                    $allowedCount = in_array('*', $allowedTpls) ? count($templates) : count(array_intersect(array_keys($templates), $allowedTpls));
                                @endphp
                                <th class="text-center" style="min-width: 170px;">
                                    <div class="plan-col-header text-center">
                                        <div class="fw-bold text-dark fs-6">{{ $plan->name }}</div>
                                        <div class="small text-muted font-normal mt-0.5">
                                            ${{ number_format($plan->price, 0) }} / {{ number_format($plan->guest_limit) }} {{ __('app.guests') }}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-1 mt-2">
                                            <span class="badge bg-primary text-white rounded-pill px-2 py-0.5 plan-badge-count" id="badge-plan-{{ $plan->id }}">
                                                {{ $allowedCount }}/{{ count($templates) }}
                                            </span>
                                            <button type="button" class="btn btn-light btn-col-toggle border text-primary" onclick="toggleColumn({{ $plan->id }})">
                                                {{ __('app.toggle') }}
                                            </button>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $tplKey => $tpl)
                            @php
                                $tplTitle = __($tpl['title_key']);
                                $tplBadge = __($tpl['badge_key']);
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset($tpl['image']) }}" alt="{{ $tplTitle }}" class="rounded-3 shadow-sm border" style="width: 52px; height: 52px; object-fit: cover; object-position: top;">
                                        <div>
                                            <div class="fw-bold text-dark">#{{ $tpl['num'] }} {{ $tplTitle }}</div>
                                            <small class="text-muted">ID: <code>{{ $tplKey }}</code></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $tpl['badge_bg'] }} rounded-pill px-3 py-1.5" style="font-size: 11.5px;">
                                        {{ $tplBadge }}
                                    </span>
                                </td>
                                @foreach($plans as $plan)
                                    @php
                                        $allowedTpls = is_array($plan->allowed_templates) ? $plan->allowed_templates : \App\Models\SubscriptionPlan::getDefaultTemplatesForSlug($plan->slug);
                                        $isAllowed = in_array('*', $allowedTpls) || in_array($tplKey, $allowedTpls);
                                    @endphp
                                    <td class="text-center bg-light-subtle">
                                        <div class="form-check form-switch form-switch-lg d-inline-block mb-0">
                                            <input class="form-check-input matrix-checkbox matrix-plan-{{ $plan->id }}" 
                                                   type="checkbox" 
                                                   name="plans[{{ $plan->id }}][allowed_templates][]" 
                                                   value="{{ $tplKey }}" 
                                                   id="matrix_chk_{{ $plan->id }}_{{ $tplKey }}"
                                                   {{ $isAllowed ? 'checked' : '' }}
                                                   onchange="updatePlanColumnCount({{ $plan->id }})">
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Sticky Save Actions Footer -->
            <div class="d-flex flex-wrap align-items-center justify-content-between p-4 bg-light rounded-bottom-4 border-top">
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1 text-primary"></i> 
                    {{ __('app.matrix_save_hint') }}
                </div>
                <button type="submit" class="btn btn-warning text-white fw-bold px-4 py-2.5 rounded-pill shadow-sm" style="background: #1877f2; border: none;">
                    <i class="fas fa-save me-1"></i> {{ __('app.save_all_assignments') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const totalTemplatesCount = {{ count($templates) }};

    function updatePlanColumnCount(planId) {
        const checkboxes = document.querySelectorAll(`.matrix-plan-${planId}`);
        let checkedCount = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) checkedCount++;
        });

        const badge = document.getElementById(`badge-plan-${planId}`);
        if (badge) {
            badge.textContent = `${checkedCount}/${totalTemplatesCount}`;
        }
    }

    function toggleColumn(planId) {
        const checkboxes = document.querySelectorAll(`.matrix-plan-${planId}`);
        let allChecked = true;
        checkboxes.forEach(cb => {
            if (!cb.checked) allChecked = false;
        });

        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });

        updatePlanColumnCount(planId);
    }

    function selectAllAllPlans() {
        const checkboxes = document.querySelectorAll('.matrix-checkbox');
        checkboxes.forEach(cb => cb.checked = true);
        @foreach($plans as $plan)
            updatePlanColumnCount({{ $plan->id }});
        @endforeach
    }

    function deselectAllAllPlans() {
        const checkboxes = document.querySelectorAll('.matrix-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        @foreach($plans as $plan)
            updatePlanColumnCount({{ $plan->id }});
        @endforeach
    }
</script>
@endpush
@endsection
