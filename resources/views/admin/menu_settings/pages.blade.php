@extends('layouts.admin')

@section('title', __('Pages Setup'))

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
                <a class="nav-link active fw-bold text-white shadow-sm" style="background-color: #1b2559;" href="{{ route('admin.menu-settings.pages.index') }}">
                    <i class="fas fa-file-alt me-1"></i> {{ __('Pages') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.page-actions.index') }}">
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
            <h4 class="dreams-card-title mb-1"><i class="fas fa-file-contract me-2" style="color: #1877f2;"></i> {{ __('Pages Setup') }}</h4>
            <p class="text-muted small mb-0">Configure system menu pages, route names, URLs, icons, module and sub-module assignments.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('admin.menu-settings.pages.download-template') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fas fa-download me-1"></i> {{ __('Template') }}
            </a>
            <button type="button" class="btn btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#importPageModal">
                <i class="fas fa-file-upload me-1"></i> {{ __('Import') }}
            </button>
            <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;" data-bs-toggle="modal" data-bs-target="#addPageModal">
                <i class="fas fa-file-medical me-1"></i> {{ __('Add Page') }}
            </button>
        </div>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-file-medical me-2"></i>{{ __('Add Page') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.pages.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Module</label>
                        <select name="module_id" class="form-select">
                            <option value="">None (Direct or Sub-Module)</option>
                            @foreach($modules ?? [] as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->name_kh }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module</label>
                        <select name="sub_module_id" class="form-select">
                            <option value="">None</option>
                            @foreach($subModules ?? [] as $sm)
                                <option value="{{ $sm->id }}">{{ $sm->name }} ({{ $sm->name_kh }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Please input page name (EN)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" placeholder="Please input page name (KH)">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Route Name</label>
                            <input type="text" name="route_name" class="form-control" placeholder="admin.guests.index">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">URL Path</label>
                            <input type="text" name="url_path" class="form-control" placeholder="/admin/guests">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Class <span class="text-danger">*</span></label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-address-book" required>
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

<!-- Import Page Modal -->
<div class="modal fade" id="importPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-upload me-2 text-primary"></i>{{ __('Import Pages') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.pages.import') }}" method="POST" enctype="multipart/form-data">
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

@foreach($pages as $p)
<!-- Edit Page Modal {{ $p->id }} -->
<div class="modal fade" id="editPageModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1b2559 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fas fa-edit me-2"></i>{{ __('Edit Page') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.pages.update', $p->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Module</label>
                        <select name="module_id" class="form-select">
                            <option value="">None</option>
                            @foreach($modules ?? [] as $m)
                                <option value="{{ $m->id }}" {{ $p->module_id == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->name_kh }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sub-Module</label>
                        <select name="sub_module_id" class="form-select">
                            <option value="">None</option>
                            @foreach($subModules ?? [] as $sm)
                                <option value="{{ $sm->id }}" {{ $p->sub_module_id == $sm->id ? 'selected' : '' }}>{{ $sm->name }} ({{ $sm->name_kh }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $p->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" value="{{ $p->name_kh }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Route Name</label>
                            <input type="text" name="route_name" class="form-control" value="{{ $p->route_name }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">URL Path</label>
                            <input type="text" name="url_path" class="form-control" value="{{ $p->url_path }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Class <span class="text-danger">*</span></label>
                        <input type="text" name="icon" class="form-control" value="{{ $p->icon }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $p->sort_order }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $p->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $p->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
    <script>
        $(document).ready(function() {
            $('select[name="module_id"]').on('change', function() {
                var moduleId = $(this).val();
                var $subModuleSelect = $(this).closest('form').find('select[name="sub_module_id"]');
                
                if (!moduleId) {
                    $subModuleSelect.html('<option value="">None</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route("admin.menu-settings.sub-modules.get-by-moduleid") }}',
                    type: 'GET',
                    data: { module_id: moduleId },
                    success: function(data) {
                        var options = '<option value="">None</option>';
                        $.each(data, function(index, item) {
                            options += '<option value="' + item.id + '">' + item.name + (item.name_kh ? ' (' + item.name_kh + ')' : '') + '</option>';
                        });
                        $subModuleSelect.html(options);
                    }
                });
            });
        });
    </script>
@endpush
@endsection
