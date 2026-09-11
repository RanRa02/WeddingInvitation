@extends('layouts.admin')

@section('title', __('Page Actions Setup'))

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Menu Settings Sub-Header Navigation Tabs -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <ul class="nav nav-pills nav-fill gap-2">
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.modules.index') }}">
                    <i class="fas fa-cubes me-1"></i> {{ __('Modules') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.sub-modules.index') }}">
                    <i class="fas fa-folder-open me-1"></i> {{ __('Sub-Modules') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.pages.index') }}">
                    <i class="fas fa-file-alt me-1"></i> {{ __('Pages') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active fw-bold text-white shadow-sm" style="background-color: #1b2559;" href="{{ route('admin.menu-settings.page-actions.index') }}">
                    <i class="fas fa-bolt me-1"></i> {{ __('Page Actions') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.roles.index') }}">
                    <i class="fas fa-user-shield me-1"></i> {{ __('Roles Access') }}
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-bolt me-2" style="color: #1877f2;"></i> {{ __('Page Actions Setup') }}</h4>
            <p class="text-muted small mb-0">Manage action permissions (Create, Edit, Delete, Export, Import) associated with pages.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('admin.menu-settings.page-actions.download-template') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fas fa-download me-1"></i> {{ __('Template') }}
            </a>
            <button type="button" class="btn btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#importPageActionModal">
                <i class="fas fa-file-upload me-1"></i> {{ __('Import') }}
            </button>
            <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;" data-bs-toggle="modal" data-bs-target="#addPageActionModal">
                <i class="fas fa-plus me-1"></i> {{ __('Add Action') }}
            </button>
        </div>
    </div>

    <!-- DataTable List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

<!-- Add Page Action Modal -->
<div class="modal fade" id="addPageActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-plus-circle me-2"></i>{{ __('Add Page Action') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.page-actions.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page <span class="text-danger">*</span></label>
                        <select name="page_id" class="form-select" required>
                            <option value="">Select Target Page</option>
                            @foreach($pages as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->name_kh ?? $p->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Action Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Create, Edit, Delete" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Name (KH)</label>
                            <input type="text" name="name_kh" class="form-control" placeholder="ឈ្មោះសកម្មភាព">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Name (CH)</label>
                            <input type="text" name="name_ch" class="form-control" placeholder="操作名称">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Route Name</label>
                        <input type="text" name="route_name" class="form-control" placeholder="admin.users.create">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="index">index</option>
                                <option value="create">create</option>
                                <option value="edit">edit</option>
                                <option value="edit_modal">edit_modal</option>
                                <option value="destroy">destroy</option>
                                <option value="view">view</option>
                                <option value="export">export</option>
                                <option value="import">import</option>
                                <option value="action">action</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Position <span class="text-danger">*</span></label>
                            <select name="position" class="form-select" required>
                                <option value="action">action</option>
                                <option value="top">top</option>
                                <option value="header">header</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Icon Class</label>
                            <input type="text" name="icon" class="form-control" placeholder="fa-plus">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Order</label>
                            <input type="number" name="order" class="form-control" value="1">
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

<!-- Import Page Action Modal -->
<div class="modal fade" id="importPageActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-upload me-2 text-primary"></i>{{ __('Import Page Actions') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.page-actions.import') }}" method="POST" enctype="multipart/form-data">
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

@foreach($pageActions as $pa)
<!-- Edit PageAction Modal {{ $pa->id }} -->
<div class="modal fade" id="editPageActionModal{{ $pa->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-edit me-2"></i>{{ __('Edit Page Action') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.page-actions.update', $pa->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page <span class="text-danger">*</span></label>
                        <select name="page_id" class="form-select" required>
                            @foreach($pages as $p)
                                <option value="{{ $p->id }}" {{ $pa->page_id == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->name_kh ?? $p->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Action Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $pa->name }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Name (KH)</label>
                            <input type="text" name="name_kh" class="form-control" value="{{ $pa->name_kh }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Name (CH)</label>
                            <input type="text" name="name_ch" class="form-control" value="{{ $pa->name_ch }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Route Name</label>
                        <input type="text" name="route_name" class="form-control" value="{{ $pa->route_name }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Action Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="index" {{ $pa->type === 'index' ? 'selected' : '' }}>index</option>
                                <option value="create" {{ $pa->type === 'create' ? 'selected' : '' }}>create</option>
                                <option value="edit" {{ $pa->type === 'edit' ? 'selected' : '' }}>edit</option>
                                <option value="edit_modal" {{ $pa->type === 'edit_modal' ? 'selected' : '' }}>edit_modal</option>
                                <option value="destroy" {{ $pa->type === 'destroy' ? 'selected' : '' }}>destroy</option>
                                <option value="view" {{ $pa->type === 'view' ? 'selected' : '' }}>view</option>
                                <option value="export" {{ $pa->type === 'export' ? 'selected' : '' }}>export</option>
                                <option value="import" {{ $pa->type === 'import' ? 'selected' : '' }}>import</option>
                                <option value="action" {{ $pa->type === 'action' ? 'selected' : '' }}>action</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Position <span class="text-danger">*</span></label>
                            <select name="position" class="form-select" required>
                                <option value="action" {{ $pa->position === 'action' ? 'selected' : '' }}>action</option>
                                <option value="top" {{ $pa->position === 'top' ? 'selected' : '' }}>top</option>
                                <option value="header" {{ $pa->position === 'header' ? 'selected' : '' }}>header</option>
                                <option value="other" {{ $pa->position === 'other' ? 'selected' : '' }}>other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="{{ $pa->icon }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ $pa->order }}">
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
    <script>
        $(document).ready(function() {
            $('select[name="page_id"]').on('change', function() {
                var pageId = $(this).val();
                if (!pageId) return;

                $.ajax({
                    url: '{{ route("admin.menu-settings.page-actions.get-by-pageid") }}',
                    type: 'GET',
                    data: { page_id: pageId },
                    success: function(data) {
                        console.log('Page Actions loaded for page ' + pageId + ':', data);
                    }
                });
            });
        });
    </script>
@endpush
@endsection
