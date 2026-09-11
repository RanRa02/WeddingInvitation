@php
    $module = $guest ?? $module ?? $model ?? $item ?? $data ?? $row ?? null;
    $pageActions = $pageActions ?? getPageActions();
    $currLoc = app()->getLocale();
    $locKey = ($currLoc === 'kh' || $currLoc === 'km') ? '_kh' : (($currLoc === 'ch' || $currLoc === 'zh') ? '_ch' : '');
@endphp

<div class="list-icons position-relative">
    <div class="dropdown">
        <a href="#" class="list-icons-item dropdown-toggle caret-0 text-dark text-decoration-none" data-bs-toggle="dropdown" data-bs-boundary="body" data-bs-display="static" aria-expanded="false" style="box-shadow:none;">
            <i class="fas fa-ellipsis-v icon-menu9 fs-6"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-right shadow border-0 rounded-3 p-2" style="min-width: 140px; z-index: 1060;">
           @if ($module)
                @if (!empty($pageActions['action']))
                    @foreach($pageActions['action'] as $action)
                        @php
                            $actRoute = $action['action_route'] ?? $action['route_name'] ?? '';
                            $actType  = $action['action_type']  ?? $action['type']       ?? '';
                            $actIcon  = $action['action_icon']  ?? $action['icon']       ?? 'fas fa-cog';
                            $actName  = $action['action_name' . $locKey] ?? $action['name' . $locKey] ?? $action['action_name_kh'] ?? $action['name_kh'] ?? $action['action_name'] ?? $action['name'] ?? ucfirst($actType);
                        @endphp
                        @if ($actType == 'destroy')
                            <form id="action-form-custguest-{{ $actType }}-{{ $module->id }}" action="{{ Route::has($actRoute) ? route($actRoute, [$module->id]) : route('customer.guests.destroy', $module->id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="javascript:confirm('action-form-custguest-{{ $actType }}-{{ $module->id }}')" class="dropdown-item text-danger fw-bold rounded-2 py-2">
                                <i class="{{ $actIcon }} me-2"></i>{{ $actName }}
                            </a>
                        @elseif ($actType == 'edit_modal')
                            <button type="button" class="dropdown-item text-dark fw-semibold rounded-2 py-2" data-bs-toggle="modal" data-bs-target="#editGuestModal{{ $module->id }}">
                                <i class="{{ $actIcon }} me-2 text-secondary"></i>{{ $actName }}
                            </button>
                        @else
                            <a href="{{ Route::has($actRoute) ? route($actRoute, [$module->id]) : '#' }}" class="dropdown-item text-dark fw-semibold rounded-2 py-2">
                                <i class="{{ $actIcon }} me-2 text-secondary"></i>{{ $actName }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <button type="button" class="dropdown-item text-dark fw-semibold rounded-2 py-2" data-bs-toggle="modal" data-bs-target="#editGuestModal{{ $module->id }}">
                        <i class="fas fa-pen-nib text-secondary me-2"></i>{{ __('app.edit') }}
                    </button>
                    <form id="delete-custguest-{{ $module->id }}" action="{{ route('customer.guests.destroy', $module->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="javascript:confirm('delete-custguest-{{ $module->id }}')" class="dropdown-item text-danger fw-bold rounded-2 py-2">
                        <i class="far fa-trash-alt text-danger me-2"></i>{{ __('app.delete') }}
                    </a>
                @endif
            @else
                @if (!empty($restore))
                    @php
                        $restRoute = $restore['action_route'] ?? $restore['route_name'] ?? '';
                        $restIcon  = $restore['action_icon']  ?? $restore['icon']       ?? 'fas fa-undo';
                        $restName  = $restore['action_name' . $loc] ?? $restore['action_name'] ?? $restore['name' . $loc] ?? $restore['name'] ?? __('app.restore');
                    @endphp
                    <a href="javascript:confirm('{{ Route::has($restRoute) ? route($restRoute, [$module->id]) : '#' }}')" class="dropdown-item text-success fw-bold rounded-2 py-2">
                        <i class="{{ $restIcon }} me-2"></i>{{ $restName }}
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>

@once
<script>
    function confirm(targetIdOrUrl){
        if (typeof bootbox !== 'undefined') {
            bootbox.confirm({
                title: 'Confirmation',
                message: 'Please confirm.',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if(result === true){
                        var form = document.getElementById(targetIdOrUrl);
                        if (form) {
                            form.submit();
                        } else {
                            location.href = targetIdOrUrl;
                        }
                    }
                }
            });
        } else {
            if (window.confirm('Please confirm.')) {
                var form = document.getElementById(targetIdOrUrl);
                if (form) {
                    form.submit();
                } else {
                    location.href = targetIdOrUrl;
                }
            }
        }
    }
</script>
@endonce
