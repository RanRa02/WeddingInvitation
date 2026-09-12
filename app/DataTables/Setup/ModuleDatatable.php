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
                return '<span class="badge bg-light text-dark p-2 border"><i class="fas '.$module->icon.' me-1" style="color: #d8af65;"></i> '.$module->icon.'</span>';
            })
            ->editColumn('status', function ($module) {
                return $module->status === 'active'
                    ? '<span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-1">Active</span>'
                    : '<span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-3 py-1">Inactive</span>';
            })
            ->addColumn('pages_count', function ($module) {
                return '<span class="badge bg-info bg-opacity-15 text-info rounded-pill px-3 py-1 fw-bold">'.$module->pages()->count().' Pages</span>';
            })
            ->addColumn('action', 'admin.menu_settings.modules_action')
            ->rawColumns(['icon', 'status', 'pages_count', 'action']);
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
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->name.'%')
                  ->orWhere('name_kh', 'like', '%'.$request->name.'%');
            });
        }
        if ($request->filled('status')) {
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
                    ->ajax([
                        'data' => 'function(d) {
                            d.name = $("#filter_name").val();
                            d.status = $("#filter_status").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                        'initComplete' => 'function() {
                            $("#filter").submit(function(event) {
                                event.preventDefault();
                                $("#moduledatatable").DataTable().ajax.reload();
                            });
                            var tr = document.createElement("tr");
                            tr.className = "filter-row";
                            var columns = this.api().init().columns;
                            this.api().columns().every(function (index) {
                                var column = this;
                                var td = document.createElement("td");
                                if (columns[index] && columns[index].searchable) {
                                    var input = document.createElement("input");
                                    input.className = "column-filter form-control form-control-sm";
                                    input.dataset.col = index;
                                    $(input).on("change keyup clear", function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    }).appendTo(td);
                                }
                                $(td).appendTo(tr);
                            });
                            $(".dataTables_scrollHeadInner table thead, #moduledatatable thead").append(tr);
                        }'
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
        return 'Module_' . date('YmdHis');
    }
}
