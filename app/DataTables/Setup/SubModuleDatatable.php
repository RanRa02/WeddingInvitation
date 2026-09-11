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
                return '<span class="badge bg-light text-dark p-2 border"><i class="fas '.$subModule->icon.' me-1" style="color: #d8af65;"></i> '.$subModule->icon.'</span>';
            })
            ->editColumn('status', function ($subModule) {
                return $subModule->status === 'active'
                    ? '<span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-1">Active</span>'
                    : '<span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-3 py-1">Inactive</span>';
            })
            ->addColumn('pages_count', function ($subModule) {
                return '<span class="badge bg-info bg-opacity-15 text-info rounded-pill px-3 py-1 fw-bold">'.$subModule->pages()->count().' Pages</span>';
            })
            ->addColumn('action', 'admin.menu_settings.sub_modules_action')
            ->rawColumns(['module_id', 'icon', 'status', 'pages_count', 'action']);
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
        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->name.'%')
                  ->orWhere('name_kh', 'like', '%'.$request->name.'%');
            });
        }
        if ($request->module_id) {
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
                    ->ajax([
                        'data' => 'function(d) {
                            d.name = $("#name").val();
                            d.module_id = $("#module_id").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                        'initComplete' => 'function() {
                            $("#filter").submit(function(event) {
                                event.preventDefault();
                                $("#submoduledatatable").DataTable().ajax.reload();
                            });
                        }'
                    ])
                    ->orderBy(3, 'ASC');
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
            Column::computed('module_id')->title(__('app.parent_module')),
            Column::make('name')->title(__('app.sub_module_name')),
            Column::computed('icon')->title(__('app.icon'))->width(100)->addClass('text-center'),
            Column::make('sort_order')->title(__('app.order'))->width(80)->addClass('text-center'),
            Column::make('status')->title(__('app.status'))->width(90)->addClass('text-center'),
            Column::computed('pages_count')->title(__('app.pages'))->width(90)->addClass('text-center'),
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
        return 'SubModule_' . date('YmdHis');
    }
}
