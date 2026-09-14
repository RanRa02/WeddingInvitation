<?php

namespace App\DataTables\Setup;

use App\Models\Module;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ModuleDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('icon', function ($module) {
                $icon = $module->icon ?? 'fa-cubes';
                $iconClass = str_starts_with($icon, 'fa-') ? 'fas ' . $icon : (str_contains($icon, 'fa') ? $icon : 'fas ' . $icon);
                return '<div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; background: rgba(24, 119, 242, 0.08); color: #1877f2; font-size: 15px;"><i class="'.$iconClass.'"></i></div>';
            })
            ->editColumn('status', function ($module) {
                return $module->status === 'active'
                    ? '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(40, 199, 111, 0.15) !important; color: #1e874b !important; border: 1px solid rgba(40, 199, 111, 0.3) !important; font-size: 11.5px;">Active</span>'
                    : '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(234, 84, 85, 0.15) !important; color: #d63031 !important; border: 1px solid rgba(234, 84, 85, 0.3) !important; font-size: 11.5px;">Inactive</span>';
            })
            ->addColumn('action', 'admin.menu_settings.modules_action')
            ->rawColumns(['icon', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Module $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Module $model, Request $request)
    {
        $query = $model->newQuery();
        if ($request->filled('name') && $request->name !== 'undefined') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'ilike', '%'.$request->name.'%')
                  ->orWhere('name_kh', 'ilike', '%'.$request->name.'%');
            });
        }
        if ($request->filled('status') && $request->status !== 'undefined') {
            $query->where('status', $request->status);
        }

        return $query->select(['modules.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('moduledatatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                    ])
                    ->orderBy(1, 'ASC');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', __('app.no'))->width(40)->addClass('text-center'),
            Column::make('name')->title(__('app.module_name')),
            Column::computed('icon')->title(__('app.icon'))->width(100)->addClass('text-center'),
            Column::make('sort_order')->title(__('app.order'))->width(80)->addClass('text-center'),
            Column::make('status')->title(__('app.status'))->width(90)->addClass('text-center'),
            Column::computed('action', __('app.actions'))->exportable(false)->printable(false)->width(60)->addClass('text-end'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Module_' . date('YmdHis');
    }
}
