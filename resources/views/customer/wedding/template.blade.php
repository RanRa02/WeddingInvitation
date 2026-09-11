@extends('layouts.customer')

@section('title', 'Select Theme Template')
@section('page_title', 'ជ្រើសរើសម៉ូដធៀបការ (Select Theme Template)')

@section('content')
<form action="{{ route('customer.wedding.template.set') }}" method="POST">
    @csrf

    <div class="row g-4 justify-content-center mb-4">
        <!-- Married Classic Template -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden text-center p-3 {{ $wedding->theme_template == 'married' ? 'border border-2 border-danger' : '' }}">
                <div class="p-3 bg-light rounded-4 mb-3">
                    <i class="fa-solid fa-gem display-1 text-danger"></i>
                </div>
                <h5 class="fw-bold text-dark">Married Classic</h5>
                <p class="small text-muted mb-3">ទម្រង់បែបបុរាណចម្រើនកាយ ពណ៌មាស និងផ្កាកុលាប ស្រស់ស្អាតប្រណីត។</p>
                <div class="mt-auto">
                    <input type="radio" class="btn-check" name="template" id="tpl_married" value="married" {{ $wedding->theme_template == 'married' ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger w-100 rounded-pill" for="tpl_married">
                        <i class="fa-solid fa-circle-check me-1"></i> ជ្រើសរើស Married Classic
                    </label>
                </div>
            </div>
        </div>

        <!-- Sapphire Modern Template -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden text-center p-3 {{ $wedding->theme_template == 'sapphire' ? 'border border-2 border-primary' : '' }}">
                <div class="p-3 bg-light rounded-4 mb-3">
                    <i class="fa-solid fa-crown display-1 text-primary"></i>
                </div>
                <h5 class="fw-bold text-dark">Sapphire Luxury</h5>
                <p class="small text-muted mb-3">ទម្រង់ពណ៌ខៀវ Sapphire លាយលម្អអក្សរមាស ស្ទីលអឺរ៉ុបទាន់សម័យ។</p>
                <div class="mt-auto">
                    <input type="radio" class="btn-check" name="template" id="tpl_sapphire" value="sapphire" {{ $wedding->theme_template == 'sapphire' ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary w-100 rounded-pill" for="tpl_sapphire">
                        <i class="fa-solid fa-circle-check me-1"></i> ជ្រើសរើស Sapphire Luxury
                    </label>
                </div>
            </div>
        </div>

        <!-- Ruby Rose Template -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden text-center p-3 {{ $wedding->theme_template == 'ruby' ? 'border border-2 border-warning' : '' }}">
                <div class="p-3 bg-light rounded-4 mb-3">
                    <i class="fa-solid fa-heart display-1 text-warning"></i>
                </div>
                <h5 class="fw-bold text-dark">Ruby Rose</h5>
                <p class="small text-muted mb-3">ទម្រង់ពណ៌ផ្កាឈូកផ្កាកុលាប និងបេះដូង ផ្តល់បរិយាកាសរ៉ូមែនទិកផ្អែមល្ហែម។</p>
                <div class="mt-auto">
                    <input type="radio" class="btn-check" name="template" id="tpl_ruby" value="ruby" {{ $wedding->theme_template == 'ruby' ? 'checked' : '' }}>
                    <label class="btn btn-outline-warning w-100 rounded-pill" for="tpl_ruby">
                        <i class="fa-solid fa-circle-check me-1"></i> ជ្រើសរើស Ruby Rose
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('w.show', $wedding->slug) }}" target="_blank" class="btn btn-outline-dark rounded-pill px-4">
            <i class="fa-solid fa-eye me-1"></i> មើលធៀបការផ្ទាល់ (Preview)
        </a>
        <button type="submit" class="btn btn-danger rounded-pill px-5">
            <i class="fa-solid fa-check me-1"></i> រក្សាទុក & បន្តទៅរៀបចំភ្ញៀវ &rarr;
        </button>
    </div>
</form>
@endsection
