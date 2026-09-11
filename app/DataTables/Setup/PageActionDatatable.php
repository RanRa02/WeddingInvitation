<?php

namespace App\DataTables\Setup;

use App\Models\PageAction;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageActionDatatable extends DataTable
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
            ->editColumn('page_id', function ($action) {
                return '<span class="badge bg-primary bg-opacity-10 text-primary border px-3 py-1 fw-bold">
                    <i class="fas '.($action->page->icon ?? 'fa-file-alt').' me-1"></i>
                    '.($action->page->name ?? 'None').'
                </span>';
            })
            ->editColumn('type', function ($action) {
                return '<span class="badge bg-info bg-opacity-15 text-info rounded-pill px-3 py-1">'.$action->type.'</span>';
            })
            ->editColumn('position', function ($action) {
                return '<span class="badge bg-secondary bg-opacity-15 text-dark rounded-pill px-3 py-1">'.$action->position.'</span>';
            })
            ->editColumn('icon', function ($action) {
                return '<span class="badge bg-light text-dark p-2 border"><i class="fas '.($action->icon ?? 'fa-bolt').' me-1"></i> '.($action->icon ?? 'fa-bolt').'</span>';
            })
            ->addColumn('action', 'admin.menu_settings.page_actions_action')
            ->rawColumns(['page_id', 'type', 'position', 'icon', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param PageAction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PageAction $model, Request $request)
    {
        $query = $model->newQuery()->with('page');
        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->name.'%')
                  ->orWhere('name_kh', 'like', '%'.$request->name.'%');
            });
        }
        if ($request->page_id) {
            $query->where('page_id', $request->page_id);
        }

        return $query->select(['page_actions.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pageactiondatatable')
                    ->columns($this->getColumns())
                    ->ajax([
                        'data' => 'function(d) {
                            d.name = $("#name").val();
                            d.page_id = $("#page_id").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                        'initComplete' => 'function() {
                            $("#filter").submit(function(event) {
                                event.preventDefault();
                                $("#pageactiondatatable").DataTable().ajax.reload();
                            });
                        }'
                    ])
                    ->orderBy(0, 'ASC');
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
            Column::computed('page_id')->title(__('app.page')),
            Column::make('name')->title(__('app.action_name')),
            Column::make('route_name')->title(__('app.route_name')),
            Column::computed('type')->title(__('app.type'))->width(90)->addClass('text-center'),
            Column::computed('position')->title(__('app.position'))->width(90)->addClass('text-center'),
            Column::computed('icon')->title(__('app.icon'))->width(100)->addClass('text-center'),
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
        return 'PageAction_' . date('YmdHis');
    }
}
