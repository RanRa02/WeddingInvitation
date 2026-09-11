@php
    $module = $guest ?? $overtime ?? $module ?? $model ?? $item ?? $data ?? $row ?? null;
    $pageActions = $pageActions ?? getPageActions();
    $restore = $restore ?? $pageActions['restore'] ?? null;
    $currLoc = app()->getLocale();
    $locale = ($currLoc === 'kh' || $currLoc === 'km') ? '_kh' : (($currLoc === 'ch' || $currLoc === 'zh') ? '_ch' : '');
@endphp

<div class="list-icons position-relative">
    <div class="dropdown">
        <a href="#" class="list-icons-item dropdown-toggle caret-0 text-dark text-decoration-none" data-toggle="dropdown" data-bs-toggle="dropdown" data-bs-boundary="body" data-bs-display="static" aria-expanded="false" style="box-shadow:none;">
            <i class="icon-menu9 fas fa-ellipsis-v fs-6"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 140px; z-index: 1060;">
            @if ($module && !$module->deleted_at)
                @isset($pageActions['action'])
                    @foreach($pageActions['action'] as $action)
                        @if ($action['action_type'] == 'destroy')
                            <form id="action-form-custguest-{{ $action['action_type'] }}-{{ $module->id }}" action="{{ Route::has($action['action_route']) ? route($action['action_route'], [$module->id]) : route('customer.guests.destroy', $module->id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="javascript:confirm('{{ Route::has($action['action_route']) ? route($action['action_route'], [$module->id]) : route('customer.guests.destroy', $module->id) }}', 'action-form-custguest-{{ $action['action_type'] }}-{{ $module->id }}')" class="dropdown-item text-danger fw-bold rounded-2 py-2">
                                <i class="{{ $action['action_icon'] }} me-2"></i>{{ $action['action_name'. $locale] ?? $action['action_name'] }}
                            </a>
                        @else
                            <a href="{{ Route::has($action['action_route']) ? route($action['action_route'], [$module->id]) : '#' }}" class="dropdown-item text-dark fw-semibold rounded-2 py-2">
                                <i class="{{ $action['action_icon'] }} me-2 text-secondary"></i>{{ $action['action_name'. $locale] ?? $action['action_name'] }}
                            </a>
                        @endif
                    @endforeach
                @endisset
            @else
                @if (isset($restore) && $restore && $module)
                    <a href="javascript:confirm('{{ Route::has($restore['action_route']) ? route($restore['action_route'], [$module->id]) : '#' }}')" class="dropdown-item text-success fw-bold rounded-2 py-2">
                        <i class="{{ $restore['action_icon'] }} me-2"></i>{{ $restore['action_name'. $locale] ?? $restore['action_name'] }}
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>

@once
<script>
    function confirm(url, formId){
        var target = formId || url;
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
                        var form = document.getElementById(target);
                        if (form) {
                            form.submit();
                        } else {
                            location.href = url;
                        }
                    }
                }
            });
        } else {
            if (window.confirm('Please confirm.')) {
                var form = document.getElementById(target);
                if (form) {
                    form.submit();
                } else {
                    location.href = url;
                }
            }
        }
    }
</script>
@endonce
