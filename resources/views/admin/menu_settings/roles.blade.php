@extends('layouts.admin')

@section('title', __('Roles Setup'))

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
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
                <a class="nav-link fw-bold text-dark" href="{{ route('admin.menu-settings.page-actions.index') }}">
                    <i class="fas fa-bolt me-1"></i> {{ __('Page Actions') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active fw-bold text-white shadow-sm" style="background-color: #1b2559;" href="{{ route('admin.menu-settings.roles.index') }}">
                    <i class="fas fa-user-shield me-1"></i> {{ __('Roles Access') }}
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm mb-4">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-user-shield me-2" style="color: #1877f2;"></i> {{ __('Roles Setup') }}</h4>
            <p class="text-muted small mb-0">Manage system user roles, access permissions, and page permissions matrix.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;">
                <i class="fas fa-plus-circle me-1"></i> {{ __('Add Role') }}
            </a>
            <button type="submit" form="roleAccessForm" class="btn btn-primary font-semibold rounded-pill px-4 shadow-sm" style="background: #1877f2; border: none;">
                <i class="fas fa-save me-1"></i> {{ __('Save Permissions') }}
            </button>
        </div>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive p-3">
        {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
    </div>
</div>

<!-- ==================== SECTION 2: ROLE PERMISSIONS MATRIX ==================== -->
<div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #1877f2 !important;">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle">
        <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fas fa-user-shield me-2"></i>Role & Menu Access Permission Matrix</span>
        <button type="submit" form="roleAccessForm" class="btn btn-sm btn-primary rounded-pill px-3" style="background: #1877f2; border: none;">
            <i class="fas fa-check-circle me-1"></i> Save Changes
        </button>
    </div>
    <div class="card-body p-0">
        <form action="{{ route('admin.menu-settings.role-access.save') }}" method="POST" id="roleAccessForm">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead style="background: #1877f2; color: #ffffff;">
                        <tr>
                            <th class="ps-4 py-3 text-white" style="width: 250px;">Page / Module</th>
                            @foreach($roles as $role)
                                <th class="text-center py-3 text-white" style="min-width: 220px;">
                                    <div class="fw-bold fs-6">{{ $role->name }}</div>
                                    <span class="badge bg-light text-dark font-monospace px-2 py-1 mt-1">{{ $role->slug }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $mod)
                            <!-- Module Group Header -->
                            <tr class="table-secondary">
                                <td colspan="{{ count($roles) + 1 }}" class="ps-4 fw-bold py-2 text-dark bg-light">
                                    <i class="fas {{ $mod->icon }} me-2" style="color: #1877f2;"></i>
                                    {{ $mod->name }} ({{ $mod->name_kh }})
                                </td>
                            </tr>

                            @forelse($mod->pages as $page)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><i class="fas {{ $page->icon }} me-2 text-muted"></i>{{ $page->name }}</div>
                                        <div class="text-muted small ms-4">{{ $page->name_kh }} | <code>{{ $page->route_name }}</code></div>
                                    </td>
                                    @foreach($roles as $role)
                                        @php
                                            $access = isset($roleAccess[$role->id]) ? $roleAccess[$role->id]->firstWhere('page_id', $page->id) : null;
                                            $canView = $access ? $access->can_view : false;
                                            $canCreate = $access ? $access->can_create : false;
                                            $canEdit = $access ? $access->can_edit : false;
                                            $canDelete = $access ? $access->can_delete : false;
                                        @endphp
                                        <td class="text-center bg-white p-3">
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <label class="form-check-label border rounded-2 px-2 py-1 small bg-light d-flex align-items-center gap-1 cursor-pointer">
                                                    <input type="checkbox" name="access[{{ $role->id }}][{{ $page->id }}][can_view]" class="form-check-input mt-0" {{ $canView ? 'checked' : '' }}>
                                                    <span class="fw-semibold text-dark">View</span>
                                                </label>
                                                <label class="form-check-label border rounded-2 px-2 py-1 small bg-light d-flex align-items-center gap-1 cursor-pointer">
                                                    <input type="checkbox" name="access[{{ $role->id }}][{{ $page->id }}][can_create]" class="form-check-input mt-0" {{ $canCreate ? 'checked' : '' }}>
                                                    <span class="fw-semibold text-dark">Create</span>
                                                </label>
                                                <label class="form-check-label border rounded-2 px-2 py-1 small bg-light d-flex align-items-center gap-1 cursor-pointer">
                                                    <input type="checkbox" name="access[{{ $role->id }}][{{ $page->id }}][can_edit]" class="form-check-input mt-0" {{ $canEdit ? 'checked' : '' }}>
                                                    <span class="fw-semibold text-dark">Edit</span>
                                                </label>
                                                <label class="form-check-label border rounded-2 px-2 py-1 small bg-light d-flex align-items-center gap-1 cursor-pointer">
                                                    <input type="checkbox" name="access[{{ $role->id }}][{{ $page->id }}][can_delete]" class="form-check-input mt-0" {{ $canDelete ? 'checked' : '' }}>
                                                    <span class="fw-semibold text-dark">Delete</span>
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td class="ps-4 text-muted fst-italic" colspan="{{ count($roles) + 1 }}">No pages registered under this module</td>
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-white border-top d-flex justify-content-end">
                <button type="submit" class="btn text-white fw-medium px-4" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">
                    <i class="fas fa-save me-1"></i> Save Permission Matrix
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
