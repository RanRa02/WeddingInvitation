@extends('layouts.admin')

@section('title', __('Sub-Modules Setup'))

@section('content')
<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-folder-open me-2" style="color: #1877f2;"></i> {{ __('Sub-Modules Setup') }}</h4>
            <p class="text-muted small mb-0">Manage secondary module groupings and sub-navigation links.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('admin.menu-settings.sub-modules.download-template') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fas fa-download me-1"></i> {{ __('Template') }}
            </a>
            <button type="button" class="btn btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#importSubModuleModal">
                <i class="fas fa-file-upload me-1"></i> {{ __('Import') }}
            </button>
            <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;" data-bs-toggle="modal" data-bs-target="#addSubModuleModal">
                <i class="fas fa-plus me-1"></i> {{ __('Add Sub-Module') }}
            </button>
        </div>
    </div>

    <!-- DataTable List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

<!-- Add Sub-Module Modal -->
<div class="modal fade" id="addSubModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-plus-circle me-2"></i>{{ __('Add Sub-Module') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.sub-modules.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Module <span class="text-danger">*</span></label>
                        <select name="module_id" class="form-select" required>
                            <option value="">Select Parent Module</option>
                            @foreach($modules as $mod)
                                <option value="{{ $mod->id }}">{{ $mod->name }} ({{ $mod->name_kh ?? $mod->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Please input sub-module name (EN)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" placeholder="Please input sub-module name (KH)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Class (FontAwesome) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-folder-open" value="fa-folder-open" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Sub-Module Modal -->
<div class="modal fade" id="importSubModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-upload me-2 text-primary"></i>{{ __('Import Sub-Modules') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.sub-modules.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Excel/CSV File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">{{ __('Upload & Import') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($subModules as $sm)
<!-- Edit SubModule Modal {{ $sm->id }} -->
<div class="modal fade" id="editSubModuleModal{{ $sm->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-edit me-2"></i>{{ __('Edit Sub-Module') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.sub-modules.update', $sm->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Module <span class="text-danger">*</span></label>
                        <select name="module_id" class="form-select" required>
                            @foreach($modules as $mod)
                                <option value="{{ $mod->id }}" {{ $sm->module_id == $mod->id ? 'selected' : '' }}>{{ $mod->name }} ({{ $mod->name_kh ?? $mod->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $sm->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" value="{{ $sm->name_kh }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Class (FontAwesome) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" class="form-control" value="{{ $sm->icon }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $sm->sort_order }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $sm->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $sm->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">{{ __('Update') }}</button>
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
