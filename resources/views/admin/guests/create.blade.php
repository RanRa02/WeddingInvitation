@extends('layouts.admin')

@section('title', __('app.add_guest'))

@section('content')
<div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #1b2559 !important;">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle cursor-pointer" data-bs-toggle="collapse" data-bs-target="#guestFormCard" aria-expanded="true">
        <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fa-solid fa-user-plus me-2"></i>{{ __('app.add_guest') }}</span>
        <a class="text-primary fs-6 text-decoration-none">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
    <div class="collapse show" id="guestFormCard">
        <div class="card-body p-4">
            <div class="col-12 col-md-9 col-lg-7 mx-auto">
                <form action="{{ route('admin.guests.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('app.guest_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('app.guest_name') }}" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('app.side') }} <span class="text-danger">*</span></label>
                        <select name="side" class="form-select" required>
                            <option value="">{{ __('app.please_select') }}</option>
                            <option value="groom" {{ old('side') === 'groom' ? 'selected' : '' }}>{{ __('app.groom_side') }}</option>
                            <option value="bride" {{ old('side') === 'bride' ? 'selected' : '' }}>{{ __('app.bride_side') }}</option>
                            <option value="both" {{ old('side') === 'both' ? 'selected' : '' }}>{{ __('app.both_sides') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('app.table') }}</label>
                        <input type="text" name="table_number" class="form-control" value="{{ old('table_number') }}" placeholder="{{ __('app.table') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('app.status') }} <span class="text-danger">*</span></label>
                        <select name="attendance" class="form-select" required>
                            <option value="">{{ __('app.please_select') }}</option>
                            <option value="pending" {{ old('attendance', 'pending') === 'pending' ? 'selected' : '' }}>{{ __('app.pending') }}</option>
                            <option value="attending" {{ old('attendance') === 'attending' ? 'selected' : '' }}>{{ __('app.attending') }}</option>
                            <option value="declined" {{ old('attendance') === 'declined' ? 'selected' : '' }}>{{ __('app.declined') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('app.companions') }} <span class="text-danger">*</span></label>
                        <input type="number" name="companions" min="1" max="20" class="form-control" value="{{ old('companions', 1) }}" required>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3">
                        <a href="{{ route('admin.guests.index') }}" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;">{{ __('app.cancel') }}</a>
                        <button type="submit" name="action" value="save" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">{{ __('app.save') }}</button>
                        <button type="submit" name="action" value="save_and_new" class="btn text-white fw-medium px-4" style="background-color: #00cfe8; border: none; font-size: 13px; border-radius: 4px;">{{ __('app.save_and_new') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
