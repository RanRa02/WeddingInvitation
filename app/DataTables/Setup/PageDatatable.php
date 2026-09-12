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
            ->editColumn('icon', function ($page) {
                return '<i class="fas '.($page->icon ?? 'fa-file-alt').'"></i>';
            })
            ->editColumn('module_id', function ($page) {
                return $page->module_name ? $page->module_name : 'N/A';
            })
            ->editColumn('sub_module_id', function ($page) {
                return $page->sub_module_name ? $page->sub_module_name : 'N/A';
            })
            ->editColumn('is_border_bottom', function ($page) {
                return $page->is_border_bottom 
                    ? '<span class="badge bg-danger text-white rounded-1 px-2 py-1">No</span>' 
                    : '<span class="badge bg-danger text-white rounded-1 px-2 py-1">No</span>';
            })
            ->addColumn('action', 'admin.menu_settings.pages_action')
            ->rawColumns(['icon', 'module_id', 'sub_module_id', 'is_border_bottom', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Page $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model, Request $request)
    {
        $query = $model->newQuery()
            ->leftJoin('modules', 'pages.module_id', 'modules.id')
            ->leftJoin('sub_modules', 'pages.sub_module_id', 'sub_modules.id')
            ->leftJoin('modules AS second_modules', 'sub_modules.module_id', 'second_modules.id');

        if ($request->filled('module_id')) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.module_id', $request->module_id)
                  ->orWhere('sub_modules.module_id', $request->module_id);
            });
        }
        if ($request->filled('sub_module_id')) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.sub_module_id', $request->sub_module_id)
                  ->orWhere('sub_modules.id', $request->sub_module_id);
            });
        }
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.name', 'like', '%'.$request->name.'%')
                  ->orWhere('pages.name_kh', 'like', '%'.$request->name.'%');
            });
        }

        return $query->selectRaw("pages.id, pages.icon, pages.name, pages.name_kh, pages.is_border_bottom, pages.sort_order,
                CASE
                    WHEN modules.name IS NOT NULL THEN modules.name
                    ELSE second_modules.name
                END AS module_name,
                sub_modules.name AS sub_module_name");
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
                            d.name = $("#filter_name").val();
                            d.module_id = $("#filter_module_id").val();
                            d.sub_module_id = $("#filter_sub_module_id").val();
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
                            $("#pagedatatable thead").append(tr);
                        }'
                    ])
                    ->orderBy(6, 'ASC');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', __('Nº'))->width(40)->addClass('text-center'),
            Column::make('icon')->title(__('Icon'))->width(50)->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('name')->title(__('Page Name')),
            Column::make('name_kh')->title(__('Page Name (KH)')),
            Column::make('module_id', 'modules.name')->title(__('Module Name'))->orderable(false)->searchable(false),
            Column::make('sub_module_id', 'sub_modules.name')->title(__('Sub Module Name'))->orderable(false)->searchable(false),
            Column::make('sort_order')->title(__('Order'))->width(80)->addClass('text-center'),
            Column::make('is_border_bottom')->title(__('Border Bottom'))->width(90)->addClass('text-center')->orderable(false)->searchable(false),
            Column::computed('action', __('Action'))->exportable(false)->printable(false)->width(60)->addClass('text-end'),
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
