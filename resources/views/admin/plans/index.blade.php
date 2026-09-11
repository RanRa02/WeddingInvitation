@extends('layouts.admin')

@section('title', 'Subscription Plans Management')
@section('page_title', 'គ្រប់គ្រងកញ្ចប់សេវា & តម្លៃ (Subscription Plans Management)')

@section('content')
<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm mb-4">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-tags me-2" style="color: #1877f2;"></i> គ្រប់គ្រងកញ្ចប់សេវា (Subscription Plans)</h4>
            <p class="text-muted small mb-0">កំណត់ចំនួនភ្ញៀវចូលរួម (Guest Limit) តម្លៃកញ្ចប់ និងបញ្ជុះតម្លៃសម្រាប់អតិថិជន</p>
        </div>
        <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;" data-bs-toggle="modal" data-bs-target="#createPlanModal">
            <i class="fas fa-plus me-1"></i> បន្ថែម Plan ថ្មី (Add New Plan)
        </button>
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
            <div class="modal-header border-0 bg-warning text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus me-2"></i> បង្កើត Plan ថ្មី (Create New Plan)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.plans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ឈ្មោះ Plan (Plan Name) <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="ឧ. VIP Platinum Plan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ចំនួនភ្ញៀវចូលរួម (Guest Limit) <span class="text-danger">*</span></label>
                            <input type="number" name="guest_limit" class="form-control" placeholder="ឧ. 500" required min="1">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">តម្លៃលក់ ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="49.00" required min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">តម្លៃដើម ($ Original)</label>
                            <input type="number" step="0.01" name="original_price" class="form-control" placeholder="79.00">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">បញ្ជុះតម្លៃ (Discount %)</label>
                            <input type="number" step="0.1" name="discount_percentage" class="form-control" placeholder="20" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">រយៈពេលប្រើប្រាស់ (Duration Days) <span class="text-danger">*</span></label>
                            <input type="number" name="duration_days" class="form-control" value="60" required min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ស្ថានភាព (Active Status)</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="activeNew" checked>
                                <label class="form-check-label" for="activeNew">បើកដំណើរការ (Active)</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">បរិយាយ (Description)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="ព័ត៌មានសង្ខេបអំពីកញ្ចប់នេះ..."></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">លក្ខណៈពិសេស (Features - ១ជួរ មួយចំណុច)</label>
                            <textarea name="features" class="form-control" rows="4" placeholder="ចំនួនភ្ញៀវ ៥០០ នាក់&#10;គ្រប់ Template ទាំងអស់&#10;VIP Support 24/7"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">បោះបង់</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold px-4">
                        <i class="fas fa-plus me-1"></i> បង្កើត Plan ថ្មី
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($plans ?? [] as $plan)
<!-- Edit Plan Modal {{ $plan->id }} -->
<div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 bg-warning text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> កែប្រែ Plan (Edit Plan)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ឈ្មោះ Plan (Plan Name) <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ចំនួនភ្ញៀវចូលរួម (Guest Limit) <span class="text-danger">*</span></label>
                            <input type="number" name="guest_limit" class="form-control" value="{{ $plan->guest_limit }}" required min="1">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">តម្លៃលក់ ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $plan->price }}" required min="0">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">តម្លៃដើម ($ Original)</label>
                            <input type="number" step="0.01" name="original_price" class="form-control" value="{{ $plan->original_price }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">បញ្ជុះតម្លៃ (Discount %)</label>
                            <input type="number" step="0.1" name="discount_percentage" class="form-control" value="{{ $plan->discount_percentage }}" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">រយៈពេលប្រើប្រាស់ (Duration Days) <span class="text-danger">*</span></label>
                            <input type="number" name="duration_days" class="form-control" value="{{ $plan->duration_days }}" required min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ស្ថានភាព (Active Status)</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="activePlan{{ $plan->id }}" {{ $plan->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="activePlan{{ $plan->id }}">បើកដំណើរការ (Active)</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">បរិយាយ (Description)</label>
                            <textarea name="description" class="form-control" rows="2">{{ $plan->description }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">លក្ខណៈពិសេស (Features - ១ជួរ មួយចំណុច)</label>
                            <textarea name="features" class="form-control" rows="4">{{ is_array($plan->features) ? implode("\n", $plan->features) : $plan->features }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">បោះបង់</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold px-4">
                        <i class="fas fa-save me-1"></i> រក្សាទុកការកែប្រែ
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
