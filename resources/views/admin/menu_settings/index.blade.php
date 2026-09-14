@extends('layouts.admin')

@section('title', __('Role & Menu Setting'))

@section('content')
<!-- Page Header Banner -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1"><i class="fas fa-sliders-h me-2" style="color: #1877f2;"></i> {{ __('Role & Menu Setting') }}</h3>
        <p class="text-muted small mb-0">កំណត់រចនាសម្ព័ន្ធម៉ូឌុល (Modules), ទំព័រ (Pages) និងកំណត់សិទ្ធិចូលប្រើប្រាស់សម្រាប់តួនាទី</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;" data-bs-toggle="modal" data-bs-target="#addModuleModal">
            <i class="fas fa-folder-plus me-1"></i> {{ __('Add Module') }}
        </button>
        <button class="btn btn-primary font-semibold rounded-pill px-4 shadow-sm" style="background: #1b2559; border: none;" data-bs-toggle="modal" data-bs-target="#addPageModal">
            <i class="fas fa-file-medical me-1"></i> {{ __('Add Page') }}
        </button>
    </div>
</div>

@php
    $currentTab = request('tab', 'modules');
@endphp

<!-- Tabs Navigation -->
<ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-4 shadow-sm border" id="menuSettingTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $currentTab === 'modules' ? 'active' : '' }} rounded-pill fw-bold px-4" id="modules-tab" data-bs-toggle="pill" data-bs-target="#modules-tab-pane" type="button" role="tab">
            <i class="fas fa-folder-plus me-2"></i> 1. Modules Setup ({{ count($modules) }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $currentTab === 'pages' ? 'active' : '' }} rounded-pill fw-bold px-4" id="pages-tab" data-bs-toggle="pill" data-bs-target="#pages-tab-pane" type="button" role="tab">
            <i class="fas fa-file-contract me-2"></i> 2. Pages Setup ({{ count($pages) }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $currentTab === 'matrix' ? 'active' : '' }} rounded-pill fw-bold px-4" id="matrix-tab" data-bs-toggle="pill" data-bs-target="#matrix-tab-pane" type="button" role="tab">
            <i class="fas fa-user-shield me-2"></i> 3. Roles Setup
        </button>
    </li>
</ul>

<div class="tab-content" id="menuSettingTabsContent">

    <!-- ==================== TAB 1: MODULES LIST ==================== -->
    <div class="tab-pane fade {{ $currentTab === 'modules' ? 'show active' : '' }}" id="modules-tab-pane" role="tabpanel">
        <div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
            <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <h5 class="dreams-card-title mb-0"><i class="fas fa-cubes me-2" style="color: #1877f2;"></i> Modules List</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold">Facebook Table Layout</span>
            </div>
            <div class="table-responsive">
                <table class="table table-gold-header mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;" class="text-center">Nº</th>
                            <th style="width: 50px;" class="text-center">Icon</th>
                            <th>Module ID</th>
                            <th>Module Name (KH)</th>
                            <th>Module Name</th>
                            <th>Pages Included</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        <tr class="filter-row">
                            <th></th>
                            <th></th>
                            <th><input type="text" class="column-filter" data-col="2" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="3" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="4" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="5" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="6" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="7" placeholder="..."></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $mod)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; font-size: 14px;">
                                        <i class="fas {{ $mod->icon }}"></i>
                                    </div>
                                </td>
                                <td class="fw-bold font-monospace text-dark">MOD{{ sprintf('%04d', $mod->id) }}</td>
                                <td class="fw-bold text-dark">{{ $mod->name_kh ?? $mod->name }}</td>
                                <td class="text-secondary">{{ $mod->name }}</td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1 fw-bold">
                                        <i class="fas fa-file-alt me-1"></i> {{ $mod->pages->count() }} Pages
                                    </span>
                                </td>
                                <td class="fw-bold font-monospace">{{ $mod->sort_order }}</td>
                                <td>
                                    @if($mod->status === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-light border-0 p-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #2c3e50;">
                                            <i class="fas fa-bars fs-6"></i><i class="fas fa-caret-down text-muted ms-1" style="font-size: 10px;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 140px;">
                                            <li>
                                                <form action="{{ route('admin.menu-settings.modules.destroy', $mod) }}" method="POST" class="d-block" onsubmit="return confirm('Deleting module will remove associated pages. Confirm delete?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger fw-bold rounded-2 py-2">
                                                        <i class="far fa-trash-alt text-danger"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-dark fw-semibold rounded-2 py-2" data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $mod->id }}">
                                                    <i class="fas fa-pen-nib text-secondary"></i> {{ __('Edit') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Module Modal -->
                            <div class="modal fade" id="editModuleModal{{ $mod->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom bg-light">
                                            <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-primary me-2"></i>Edit Module</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.menu-settings.modules.update', $mod) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4 text-start">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Module Name (EN)</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $mod->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Module Name (KH)</label>
                                                    <input type="text" name="name_kh" class="form-control" value="{{ $mod->name_kh }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Icon Class (FontAwesome)</label>
                                                    <input type="text" name="icon" class="form-control" value="{{ $mod->icon }}" required>
                                                    <span class="text-muted small">Example: fa-address-book, fa-users-cog, fa-sliders-h</span>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">Sort Order</label>
                                                        <input type="number" name="sort_order" class="form-control" value="{{ $mod->sort_order }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="active" {{ $mod->status === 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ $mod->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top bg-light">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">No modules found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 2: PAGES LIST ==================== -->
    <div class="tab-pane fade {{ $currentTab === 'pages' ? 'show active' : '' }}" id="pages-tab-pane" role="tabpanel">
        <div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
            <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between">
                <h5 class="dreams-card-title mb-0"><i class="fas fa-layer-group me-2" style="color: #1877f2;"></i> Pages List</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold">Facebook Table Layout</span>
            </div>
            <div class="table-responsive">
                <table class="table table-gold-header mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;" class="text-center">Nº</th>
                            <th style="width: 50px;" class="text-center">Icon</th>
                            <th>Page ID</th>
                            <th>Module Parent</th>
                            <th>Page Name (KH)</th>
                            <th>Page Name</th>
                            <th>Route Name / Path</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        <tr class="filter-row">
                            <th></th>
                            <th></th>
                            <th><input type="text" class="column-filter" data-col="2" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="3" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="4" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="5" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="6" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="7" placeholder="..."></th>
                            <th><input type="text" class="column-filter" data-col="8" placeholder="..."></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $pg)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; font-size: 14px;">
                                        <i class="fas {{ $pg->icon }}"></i>
                                    </div>
                                </td>
                                <td class="fw-bold font-monospace text-dark">PGE{{ sprintf('%04d', $pg->id) }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1">
                                        <i class="fas {{ $pg->module->icon ?? 'fa-folder' }} text-warning me-1"></i> {{ $pg->module->name ?? 'None' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">{{ $pg->name_kh ?? $pg->name }}</td>
                                <td class="text-secondary">{{ $pg->name }}</td>
                                <td>
                                    <div class="font-monospace text-primary small">{{ $pg->route_name ?? '-' }}</div>
                                    <span class="text-muted small" style="font-size: 11px;">{{ $pg->url_path ?? '-' }}</span>
                                </td>
                                <td class="fw-bold font-monospace">{{ $pg->sort_order }}</td>
                                <td>
                                    @if($pg->status === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-light border-0 p-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #2c3e50;">
                                            <i class="fas fa-bars fs-6"></i><i class="fas fa-caret-down text-muted ms-1" style="font-size: 10px;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 140px;">
                                            <li>
                                                <form action="{{ route('admin.menu-settings.pages.destroy', $pg) }}" method="POST" class="d-block" onsubmit="return confirm('Confirm delete page?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger fw-bold rounded-2 py-2">
                                                        <i class="far fa-trash-alt text-danger"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-dark fw-semibold rounded-2 py-2" data-bs-toggle="modal" data-bs-target="#editPageModal{{ $pg->id }}">
                                                    <i class="fas fa-pen-nib text-secondary"></i> {{ __('Edit') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Page Modal -->
                            <div class="modal fade" id="editPageModal{{ $pg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom bg-light">
                                            <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-primary me-2"></i>Edit Page</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.menu-settings.pages.update', $pg) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4 text-start">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Parent Module</label>
                                                    <select name="module_id" class="form-select" required>
                                                        @foreach($modules as $m)
                                                            <option value="{{ $m->id }}" {{ $pg->module_id == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->name_kh }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Page Name (EN)</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $pg->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Page Name (KH)</label>
                                                    <input type="text" name="name_kh" class="form-control" value="{{ $pg->name_kh }}">
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">Route Name</label>
                                                        <input type="text" name="route_name" class="form-control" value="{{ $pg->route_name }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">URL Path</label>
                                                        <input type="text" name="url_path" class="form-control" value="{{ $pg->url_path }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Icon Class</label>
                                                    <input type="text" name="icon" class="form-control" value="{{ $pg->icon }}" required>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">Sort Order</label>
                                                        <input type="number" name="sort_order" class="form-control" value="{{ $pg->sort_order }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="active" {{ $pg->status === 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ $pg->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top bg-light">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">No pages found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 3: ROLE & MENU ACCESS MATRIX ==================== -->
    <div class="tab-pane fade {{ $currentTab === 'matrix' ? 'show active' : '' }}" id="matrix-tab-pane" role="tabpanel">
        <form action="{{ route('admin.menu-settings.role-access.save') }}" method="POST">
            @csrf
            <div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
                <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h5 class="dreams-card-title mb-1"><i class="fas fa-user-shield me-2" style="color: #1877f2;"></i> Role & Page Access Permission Matrix</h5>
                        <p class="text-muted small mb-0">កំណត់សិទ្ធិមើល បង្កើត កែប្រែ និងលុប តាមតួនាទី (View, Create, Edit, Delete Permissions)</p>
                    </div>
                    <button type="submit" class="btn btn-success text-white font-semibold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Access Permissions
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-gold-header mb-0">
                        <thead>
                            <tr>
                                <th>Module / Page Name</th>
                                <th>Role</th>
                                <th class="text-center" style="width: 100px;">View Access</th>
                                <th class="text-center" style="width: 100px;">Create Access</th>
                                <th class="text-center" style="width: 100px;">Edit Access</th>
                                <th class="text-center" style="width: 100px;">Delete Access</th>
                            </tr>
                            <tr class="filter-row">
                                <th><input type="text" class="column-filter" data-col="0" placeholder="..."></th>
                                <th><input type="text" class="column-filter" data-col="1" placeholder="..."></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $p)
                                @foreach($roles as $r)
                                    @php
                                        $access = isset($roleAccess[$r->id]) ? $roleAccess[$r->id]->firstWhere('page_id', $p->id) : null;
                                        $canView = $access ? $access->can_view : ($r->slug === 'admin');
                                        $canCreate = $access ? $access->can_create : ($r->slug === 'admin');
                                        $canEdit = $access ? $access->can_edit : ($r->slug === 'admin');
                                        $canDelete = $access ? $access->can_delete : ($r->slug === 'admin');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas {{ $p->icon }} text-warning fs-6"></i>
                                                <div>
                                                    <span class="fw-bold text-dark">{{ $p->name_kh ?? $p->name }}</span>
                                                    <span class="text-muted small">({{ $p->module->name ?? 'Module' }} &bull; {{ $p->name }})</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold">
                                                {{ $r->name }} ({{ $r->slug }})
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input" type="checkbox" name="access[{{ $r->id }}][{{ $p->id }}][can_view]" value="1" {{ $canView ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input" type="checkbox" name="access[{{ $r->id }}][{{ $p->id }}][can_create]" value="1" {{ $canCreate ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input" type="checkbox" name="access[{{ $r->id }}][{{ $p->id }}][can_edit]" value="1" {{ $canEdit ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input" type="checkbox" name="access[{{ $r->id }}][{{ $p->id }}][can_delete]" value="1" {{ $canDelete ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-light border-top d-flex justify-content-end">
                    <button type="submit" class="btn btn-success text-white font-semibold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Access Permissions
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- ==================== MODALS ==================== -->

<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-folder-plus text-warning me-2"></i>{{ __('Add Module') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.modules.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Module Name (EN)</label>
                        <input type="text" name="name" class="form-control" placeholder="Guest Management" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Module Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" placeholder="គ្រប់គ្រងភ្ញៀវ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-address-book" required>
                        <span class="text-muted small">Example: fa-address-book, fa-users-cog, fa-sliders-h</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ count($modules) + 1 }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Status</label>
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

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-file-medical text-primary me-2"></i>{{ __('Add Page') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-settings.pages.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Module</label>
                        <select name="module_id" class="form-select" required>
                            @foreach($modules as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->name_kh }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (EN)</label>
                        <input type="text" name="name" class="form-control" placeholder="Guest List" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Name (KH)</label>
                        <input type="text" name="name_kh" class="form-control" placeholder="បញ្ជីភ្ញៀវ">
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
                        <label class="form-label fw-bold">Icon Class</label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-address-book" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Status</label>
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

@endsection
