@extends('layouts.admin')

@section('title', __('User Roles'))

@section('content')
<div class="dreams-card p-0 overflow-hidden border-0 shadow-sm">
    <!-- Header & Action Buttons -->
    <div class="p-4 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="dreams-card-title mb-1"><i class="fas fa-user-shield me-2" style="color: #1877f2;"></i> {{ __('User Roles') }}</h4>
            <p class="text-muted small mb-0">គ្រប់គ្រងតួនាទី និងកំណត់សិទ្ធិអនុញ្ញាតក្នុងប្រព័ន្ធ (Role & Permission Management List)</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-warning text-white font-semibold rounded-pill px-4 shadow-sm" style="background: #ff9f43; border: none;">
            <i class="fas fa-plus-circle me-1"></i> {{ __('Add Role') }}
        </a>
    </div>

    <!-- Gold Header Table List -->
    <div class="table-responsive">
        <table class="table table-gold-header mb-0">
            <thead>
                <!-- Gold Title Header Bar -->
                <tr>
                    <th style="width: 40px;" class="text-center">Nº</th>
                    <th style="width: 50px;" class="text-center">Icon</th>
                    <th>Role ID</th>
                    <th>Role Name (KH)</th>
                    <th>Role Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Users Count</th>
                    <th>Permissions</th>
                    <th class="text-end">Actions</th>
                </tr>
                <!-- Column Search Filter Row -->
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
                @forelse($roles as $role)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; font-size: 14px;">
                                <i class="fas fa-user-shield fs-6"></i>
                            </div>
                        </td>
                        <td class="fw-bold font-monospace text-dark">ROL{{ sprintf('%04d', $role->id) }}</td>
                        <td class="fw-bold text-dark">{{ $role->name }}</td>
                        <td class="text-secondary">{{ $role->name }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 font-monospace">{{ $role->slug }}</span></td>
                        <td class="text-muted small" style="max-width: 200px;">{{ $role->description ?? 'No Description' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill px-3 py-1">
                                <i class="fas fa-users text-primary me-1"></i> {{ $role->users_count }} Users
                            </span>
                        </td>
                        <td>
                            @if(!empty($role->permissions))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($role->permissions as $perm)
                                        <span class="badge bg-secondary bg-opacity-15 text-secondary rounded-pill px-2 py-1 small" style="font-size: 11px;">{{ $perm }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-light border-0 p-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; color: #2c3e50;">
                                    <i class="fas fa-bars fs-6"></i><i class="fas fa-caret-down text-muted ms-1" style="font-size: 10px;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 140px;">
                                    <li>
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-block" onsubmit="return confirm('Confirm delete role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger fw-bold rounded-2 py-2" {{ $role->users_count > 0 ? 'disabled' : '' }}>
                                                <i class="far fa-trash-alt text-danger"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="dropdown-item d-flex align-items-center gap-2 text-dark fw-semibold rounded-2 py-2">
                                            <i class="fas fa-pen-nib text-secondary"></i> {{ __('Edit') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="fas fa-user-shield fs-1 text-muted opacity-50 mb-2"></i>
                            <p class="mb-0">No roles found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
