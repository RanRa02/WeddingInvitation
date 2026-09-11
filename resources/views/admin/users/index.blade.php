@extends('layouts.admin')

@section('title', __('Users'))

@section('content')
<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-users-cog me-2" style="color: #1877f2;"></i> {{ __('Users') }}</h4>
            <p class="text-muted small mb-0">គ្រប់គ្រងគណនីអ្នកប្រើប្រាស់ និងសិទ្ធិចូលប្រើប្រាស់ប្រព័ន្ធ (User Management List)</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;">
            <i class="fas fa-user-plus me-1"></i> {{ __('Add User') }}
        </a>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
