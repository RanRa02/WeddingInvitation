@php
    $pageAction = $pageAction ?? $module ?? $model ?? $item ?? $data ?? $row ?? null;
    $loc = $locale ?? (app()->getLocale() == 'en' ? '' : '_' . app()->getLocale());
@endphp

<div class="list-icons position-relative">
    <div class="dropdown">
        <a href="#" class="list-icons-item dropdown-toggle caret-0 text-dark text-decoration-none" data-bs-toggle="dropdown" data-bs-boundary="body" data-bs-display="static" aria-expanded="false" style="box-shadow:none;">
            <i class="fas fa-ellipsis-v icon-menu9 fs-6"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-right shadow border-0 rounded-3 p-2" style="min-width: 140px; z-index: 1060;">
           @if ($pageAction && !$pageAction->deleted_at)
                <button type="button" class="dropdown-item text-dark fw-semibold rounded-2 py-2" data-bs-toggle="modal" data-bs-target="#editPageActionModal{{ $pageAction->id }}">
                    <i class="fas fa-pen-nib text-secondary me-2"></i>{{ __('app.edit') }}
                </button>
                <form id="delete-pageaction-{{ $pageAction->id }}" action="{{ route('admin.menu-settings.page-actions.destroy', $pageAction->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                <a href="javascript:confirm('delete-pageaction-{{ $pageAction->id }}')" class="dropdown-item text-danger fw-bold rounded-2 py-2">
                    <i class="far fa-trash-alt text-danger me-2"></i>{{ __('app.delete') }}
                </a>
            @endif
        </div>
    </div>
</div>
