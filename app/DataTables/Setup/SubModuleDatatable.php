<?php

namespace App\DataTables\Setup;

use App\Models\SubModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubModuleDatatable extends DataTable
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
            ->editColumn('module_id', function ($subModule) {
                return '<span class="badge bg-warning bg-opacity-10 text-dark border px-3 py-1 fw-bold">
                    <i class="fas '.($subModule->module->icon ?? 'fa-folder').' me-1" style="color: #d8af65;"></i>
                    '.($subModule->module->name ?? 'None').'
                </span>';
            })
            ->editColumn('icon', function ($subModule) {
                $icon = $subModule->icon ?? 'fa-folder';
                $iconClass = str_starts_with($icon, 'fa-') ? 'fas ' . $icon : (str_contains($icon, 'fa') ? $icon : 'fas ' . $icon);
                return '<div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; background: rgba(24, 119, 242, 0.08); color: #1877f2; font-size: 15px;"><i class="'.$iconClass.'"></i></div>';
            })
            ->editColumn('status', function ($subModule) {
                return $subModule->status === 'active'
                    ? '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(40, 199, 111, 0.15) !important; color: #1e874b !important; border: 1px solid rgba(40, 199, 111, 0.3) !important; font-size: 11.5px;">Active</span>'
                    : '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(234, 84, 85, 0.15) !important; color: #d63031 !important; border: 1px solid rgba(234, 84, 85, 0.3) !important; font-size: 11.5px;">Inactive</span>';
            })
            ->addColumn('action', 'admin.menu_settings.sub_modules_action')
            ->rawColumns(['module_id', 'icon', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param SubModule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SubModule $model, Request $request)
    {
        $query = $model->newQuery()->with('module');
        if ($request->filled('name') && $request->name !== 'undefined') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'ilike', '%'.$request->name.'%')
                  ->orWhere('name_kh', 'ilike', '%'.$request->name.'%');
            });
        }
        if ($request->filled('module_id') && $request->module_id !== 'undefined') {
            $query->where('module_id', $request->module_id);
        }

        return $query->select(['sub_modules.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('submoduledatatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                    ])
                    ->orderBy(2, 'ASC');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', __('Nº'))->width(40)->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('module_id', 'modules.name')->title(__('Parent Module'))->orderable(false)->searchable(false),
            Column::make('name')->title(__('Sub Module Name')),
            Column::make('icon')->title(__('Icon'))->width(100)->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('sort_order')->title(__('Order'))->width(80)->addClass('text-center'),
            Column::make('status')->title(__('Status'))->width(90)->addClass('text-center'),
            Column::computed('action', __('Actions'))->exportable(false)->printable(false)->width(60)->addClass('text-end'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'SubModule_' . date('YmdHis');
    }
}
