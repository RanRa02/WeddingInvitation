@extends('layouts.admin')

@section('title', __('app.subscription_plans_management'))
@section('page_title', __('app.subscription_plans_management'))

@php
    $templatesCatalog = \App\Http\Controllers\Customer\WeddingController::getTemplatesCatalog();
@endphp

@section('content')
<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm mb-4">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-tags me-2" style="color: #1877f2;"></i> {{ __('app.subscription_plans_management') }}</h4>
            <p class="text-muted small mb-0">{{ __('app.subscription_plans_subtitle') }}</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.plans.templates') }}" class="btn btn-outline-primary font-semibold rounded-pill px-3 shadow-sm">
                <i class="fas fa-layer-group me-1"></i> {{ __('app.assign_plan_templates') }}
            </a>
            <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #1877f2; border: none;" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                <i class="fas fa-plus me-1"></i> {{ __('app.add_new_plan') }}
            </button>
        </div>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

<!-- Create Plan Modal -->
<div class="modal fade" id="createPlanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 text-white rounded-top-4" style="background: #1877f2;">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus me-2"></i> {{ __('app.create_new_plan') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.plans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.plan_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('app.plan_name_placeholder') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.guest_limit') }} <span class="text-danger">*</span></label>
                            <input type="number" name="guest_limit" class="form-control" placeholder="500" required min="1">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.price') }} ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="49.00" required min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.original_price') }} ($)</label>
                            <input type="number" step="0.01" name="original_price" class="form-control" placeholder="79.00">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.discount') }} (%)</label>
                            <input type="number" step="0.1" name="discount_percentage" class="form-control" placeholder="20" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.duration_days') }} <span class="text-danger">*</span></label>
                            <input type="number" name="duration_days" class="form-control" value="60" required min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.status') }}</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="activeNew" checked>
                                <label class="form-check-label" for="activeNew">{{ __('app.active') }}</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('app.description') }}</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="..."></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('app.features_hint') }}</label>
                            <textarea name="features" class="form-control" rows="3" placeholder="500 Guests&#10;All Theme Templates&#10;VIP Support 24/7"></textarea>
                        </div>

                        <!-- Allowed Templates Selection in Create Modal -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold d-block mb-2">{{ __('app.allowed_theme_templates') }}</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="row g-2">
                                    @foreach($templatesCatalog as $tplKey => $tpl)
                                        <div class="col-6 col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="allowed_templates[]" value="{{ $tplKey }}" id="create_tpl_{{ $tplKey }}" checked>
                                                <label class="form-check-label small fw-semibold text-dark" for="create_tpl_{{ $tplKey }}">
                                                    #{{ $tpl['num'] }} {{ __($tpl['title_key']) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold px-4" style="background: #1877f2; border: none;">
                        <i class="fas fa-plus me-1"></i> {{ __('app.create_plan') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($plans ?? [] as $plan)
@php
    $planAllowedTpls = is_array($plan->allowed_templates) ? $plan->allowed_templates : \App\Models\SubscriptionPlan::getDefaultTemplatesForSlug($plan->slug);
    $isPlanAllStar = in_array('*', $planAllowedTpls);
@endphp
<!-- Edit Plan Modal {{ $plan->id }} -->
<div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 text-white rounded-top-4" style="background: #1877f2;">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> {{ __('app.edit_plan') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.plan_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.guest_limit') }} <span class="text-danger">*</span></label>
                            <input type="number" name="guest_limit" class="form-control" value="{{ $plan->guest_limit }}" required min="1">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.price') }} ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $plan->price }}" required min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.original_price') }} ($)</label>
                            <input type="number" step="0.01" name="original_price" class="form-control" value="{{ $plan->original_price }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('app.discount') }} (%)</label>
                            <input type="number" step="0.1" name="discount_percentage" class="form-control" value="{{ $plan->discount_percentage }}" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.duration_days') }} <span class="text-danger">*</span></label>
                            <input type="number" name="duration_days" class="form-control" value="{{ $plan->duration_days }}" required min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('app.status') }}</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="activePlan{{ $plan->id }}" {{ $plan->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="activePlan{{ $plan->id }}">{{ __('app.active') }}</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('app.description') }}</label>
                            <textarea name="description" class="form-control" rows="2">{{ $plan->description }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('app.features_hint') }}</label>
                            <textarea name="features" class="form-control" rows="3">{{ is_array($plan->features) ? implode("\n", $plan->features) : $plan->features }}</textarea>
                        </div>

                        <!-- Allowed Templates Selection in Edit Modal -->
                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold mb-0">{{ __('app.allowed_theme_templates') }}</label>
                                <a href="{{ route('admin.plans.templates') }}" class="small text-primary text-decoration-none">
                                    <i class="fas fa-external-link-alt me-1"></i> {{ __('app.full_manager') }}
                                </a>
                            </div>
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="row g-2">
                                    @foreach($templatesCatalog as $tplKey => $tpl)
                                        @php
                                            $isAllowed = $isPlanAllStar || in_array($tplKey, $planAllowedTpls);
                                        @endphp
                                        <div class="col-6 col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="allowed_templates[]" value="{{ $tplKey }}" id="edit_tpl_{{ $plan->id }}_{{ $tplKey }}" {{ $isAllowed ? 'checked' : '' }}>
                                                <label class="form-check-label small fw-semibold text-dark" for="edit_tpl_{{ $plan->id }}_{{ $tplKey }}">
                                                    #{{ $tpl['num'] }} {{ __($tpl['title_key']) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold px-4" style="background: #1877f2; border: none;">
                        <i class="fas fa-save me-1"></i> {{ __('app.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
