@extends('layouts.admin')

@section('title', __('Guest List'))

@section('content')
<!-- Row 1: Top 4 Small Minimal Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dreams-minimal-card">
            <div class="minimal-icon-box" style="background: #fff3e0; color: #ff9f43;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['total'] ?? 0) }}</h4>
                <span class="text-muted small fw-medium">{{ __('Total Guests') }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dreams-minimal-card">
            <div class="minimal-icon-box" style="background: #e8f5e9; color: #28c76f;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['attending'] ?? 0) }}</h4>
                <span class="text-muted small fw-medium">{{ __('Attending Guests') }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dreams-minimal-card">
            <div class="minimal-icon-box" style="background: #e0f7fa; color: #00cfe8;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['pending'] ?? 0) }}</h4>
                <span class="text-muted small fw-medium">{{ __('Pending RSVP') }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dreams-minimal-card">
            <div class="minimal-icon-box" style="background: #ffebee; color: #ea5455;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['declined'] ?? 0) }}</h4>
                <span class="text-muted small fw-medium">{{ __('Declined') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-address-book me-2" style="color: #1877f2;"></i> {{ __('Guest List') }}</h4>
            <p class="text-muted small mb-0">
                គ្រប់គ្រងបញ្ជីភ្ញៀវតាមទម្រង់តារាងមាស
                @if(!$isAdmin)
                    <span class="ms-2 badge bg-warning bg-opacity-15 text-dark border rounded-pill px-3 py-1 font-monospace">
                        <i class="fas fa-chart-pie me-1 text-warning"></i> Quota: {{ $stats['total'] ?? 0 }} / {{ auth()->user()->guest_limit ?? 100 }} Guests
                    </span>
                @endif
            </p>
        </div>
        <div>
            @if(!$isAdmin && auth()->user()->hasReachedGuestLimit())
                <span class="badge bg-danger p-2 px-3 rounded-pill">
                    <i class="fas fa-exclamation-triangle me-1"></i> Guest Limit Reached (Max {{ auth()->user()->guest_limit ?? 100 }})
                </span>
            @elseif($canCreate)
                <a href="{{ route('admin.guests.create') }}" class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;">
                    <i class="fas fa-user-plus me-1"></i> {{ __('Add Guest') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
