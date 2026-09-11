@extends('layouts.admin')

@section('title', __('Form Edit - Role'))

@section('content')
<div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #1b2559 !important;">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle">
        <span class="fw-bold fs-6" style="color: #1877f2;">Form Edit</span>
        <a data-bs-toggle="collapse" href="#roleEditFormCard" role="button" aria-expanded="true" aria-controls="roleEditFormCard" class="text-primary fs-6 text-decoration-none">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
    <div class="collapse show" id="roleEditFormCard">
        <div class="card-body p-4">
            <div class="col-12 col-md-9 col-lg-7 mx-auto">
                <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Role Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" placeholder="Please input role name" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">{{ __('Description (KH / EN)') }}</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Please input role description">{{ old('description', $role->description) }}</textarea>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3">
                        <a href="{{ route('admin.roles.index') }}" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;">Cancel</a>
                        <button type="submit" name="action" value="save" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
