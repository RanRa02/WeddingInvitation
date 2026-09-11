@extends('layouts.customer')

@section('title', 'Subscription Plans')
@section('page_title', 'កញ្ចប់សេវាកម្ម & ការទូទាត់ប្រាក់ (Subscription Plans & Payment)')

@section('content')
<div class="row g-4 justify-content-center">
    @foreach($plans as $plan)
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white d-flex flex-column border-2 {{ $currentSubscription && $currentSubscription->plan_id == $plan->id ? 'border-danger' : '' }}">
                @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                    <div class="badge bg-danger mb-2 align-self-start">កញ្ចប់បច្ចុប្បន្ន (Current)</div>
                @endif
                @if($plan->discount_percentage > 0)
                    <div class="badge bg-danger mb-2 align-self-end text-white px-2 py-1 rounded-pill">បញ្ជុះតម្លៃ -{{ number_format($plan->discount_percentage, 0) }}%</div>
                @endif
                <h4 class="fw-bold text-dark mb-1">{{ $plan->name }}</h4>
                <p class="small text-muted mb-3">{{ $plan->description }}</p>

                <div class="my-2">
                    <span class="display-6 fw-bold text-dark">${{ number_format($plan->price, 0) }}</span>
                    @if($plan->original_price)
                        <span class="text-muted text-decoration-line-through fs-6 ms-1">${{ number_format($plan->original_price, 0) }}</span>
                    @endif
                    <span class="text-muted">/ {{ $plan->duration_days }} ថ្ងៃ</span>
                </div>

                <ul class="list-unstyled my-3 flex-grow-1 small">
                    <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i> ចំនួនភ្ញៀវ: <strong>{{ number_format($plan->guest_limit) }} នាក់</strong></li>
                    @if(is_array($plan->features))
                        @foreach($plan->features as $feature)
                            <li class="mb-2 text-muted"><i class="fa-solid fa-check text-primary me-2"></i> {{ $feature }}</li>
                        @endforeach
                    @endif
                </ul>

                <button type="button" 
                        class="btn btn-danger w-100 rounded-pill py-2 mt-auto" 
                        data-bs-toggle="modal" 
                        data-bs-target="#paymentModal{{ $plan->id }}">
                    <i class="fa-solid fa-credit-card me-1"></i> ទូទាត់ប្រាក់ & ជ្រើសរើស
                </button>
            </div>
        </div>

        <!-- Payment Modal for Plan -->
        <div class="modal fade" id="paymentModal{{ $plan->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-0 bg-danger text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-qrcode me-2"></i> ទូទាត់ប្រាក់សម្រាប់: {{ $plan->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('customer.subscriptions.payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        
                        <div class="modal-body text-center p-4">
                            <h3 class="fw-bold text-danger mb-1">${{ number_format($plan->price, 2) }}</h3>
                            <p class="text-muted small mb-4">រយៈពេលប្រើប្រាស់ {{ $plan->duration_days }} ថ្ងៃ | ភ្ញៀវ {{ number_format($plan->guest_limit) }} នាក់</p>

                            <div class="mb-3">
                                <label class="fw-bold text-dark mb-2 d-block">ជ្រើសរើសវិធីសាស្ត្រទូទាត់ប្រាក់:</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="payment_method" id="khqr{{ $plan->id }}" value="khqr" checked>
                                    <label class="btn btn-outline-danger py-2" for="khqr{{ $plan->id }}">
                                        <i class="fa-solid fa-qrcode me-1"></i> KHQR / ABA Pay
                                    </label>

                                    <input type="radio" class="btn-check" name="payment_method" id="card{{ $plan->id }}" value="card">
                                    <label class="btn btn-outline-danger py-2" for="card{{ $plan->id }}">
                                        <i class="fa-solid fa-credit-card me-1"></i> Card Payment
                                    </label>
                                </div>
                            </div>

                            <!-- KHQR Mock Image Display -->
                            <div class="p-3 bg-light rounded-4 my-3 text-center border">
                                <img src="{{ asset('assets/images/QR.jpg') }}" class="img-fluid rounded mb-2" style="max-height: 180px;" alt="KHQR Code">
                                <p class="small text-muted mb-0">ស្កែន QR Code ដើម្បីទូទាត់ប្រាក់សាកល្បង</p>
                            </div>
                        </div>

                        <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">បោះបង់</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="fa-solid fa-circle-check me-1"></i> បញ្ជាក់ការទូទាត់ (Confirm Payment)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
