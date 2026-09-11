@extends('layouts.admin')

@section('title', __('Form Create - User'))

@section('content')
<div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #1b2559 !important;">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle">
        <span class="fw-bold fs-6" style="color: #1877f2;">Form Create</span>
        <a data-bs-toggle="collapse" href="#userFormCard" role="button" aria-expanded="true" aria-controls="userFormCard" class="text-primary fs-6 text-decoration-none">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
    <div class="collapse show" id="userFormCard">
        <div class="card-body p-4">
            <div class="col-12 col-md-9 col-lg-7 mx-auto">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Please input full name" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Please input email address" required>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Password') }} <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Please input password" required>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Assign Role') }}</label>
                        <select name="role_id" class="form-select">
                            <option value="">Please Select</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Account Status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="">Please Select</option>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (សកម្ម)</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (ផ្អាក)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Max Guest Limit') }} <span class="text-danger">*</span></label>
                        <input type="number" name="guest_limit" min="1" max="100000" class="form-control" value="{{ old('guest_limit', 100) }}" placeholder="Please input max guest limit" required>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;">Cancel</a>
                        <button type="submit" name="action" value="save" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">Save</button>
                        <button type="submit" name="action" value="save_and_new" class="btn text-white fw-medium px-4" style="background-color: #00cfe8; border: none; font-size: 13px; border-radius: 4px;">Save & New</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
