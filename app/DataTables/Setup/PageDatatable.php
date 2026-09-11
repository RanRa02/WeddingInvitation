<?php

namespace App\DataTables\Setup;

use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageDatatable extends DataTable
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
            ->editColumn('module_id', function ($page) {
                return '<span class="badge bg-warning bg-opacity-10 text-dark border px-3 py-1 fw-bold">
                    <i class="fas '.($page->module->icon ?? 'fa-folder').' me-1" style="color: #d8af65;"></i>
                    '.($page->module->name ?? 'None').'
                </span>';
            })
            ->editColumn('icon', function ($page) {
                return '<span class="badge bg-light text-dark p-2 border"><i class="fas '.$page->icon.' me-1" style="color: #d8af65;"></i> '.$page->icon.'</span>';
            })
            ->editColumn('status', function ($page) {
                return $page->status === 'active'
                    ? '<span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-1">Active</span>'
                    : '<span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-3 py-1">Inactive</span>';
            })
            ->addColumn('action', 'admin.menu_settings.pages_action')
            ->rawColumns(['module_id', 'icon', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Page $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model, Request $request)
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

        return $query->select(['pages.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pagedatatable')
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
                                $("#pagedatatable").DataTable().ajax.reload();
                            });
                        }'
                    ]);
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
            Column::make('name')->title(__('app.page_name')),
            Column::make('route_name')->title(__('app.route_name')),
            Column::make('url_path')->title(__('app.url_path')),
            Column::computed('icon')->title(__('app.icon'))->width(100)->addClass('text-center'),
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
        return 'Page_' . date('YmdHis');
    }
}
