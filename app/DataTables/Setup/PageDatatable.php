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
                $icon = $page->icon ?? 'fa-file-alt';
                $iconClass = str_starts_with($icon, 'fa-') ? 'fas ' . $icon : (str_contains($icon, 'fa') ? $icon : 'fas ' . $icon);
                return '<div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; background: rgba(24, 119, 242, 0.08); color: #1877f2; font-size: 15px;"><i class="'.$iconClass.'"></i></div>';
            })
            ->editColumn('module_id', function ($page) {
                return $page->module_name ? '<span class="badge bg-warning bg-opacity-10 text-dark border px-2 py-1">'.$page->module_name.'</span>' : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('sub_module_id', function ($page) {
                return $page->sub_module_name ? '<span class="badge bg-info bg-opacity-10 text-info border px-2 py-1">'.$page->sub_module_name.'</span>' : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('status', function ($page) {
                return $page->status === 'active'
                    ? '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(40, 199, 111, 0.15) !important; color: #1e874b !important; border: 1px solid rgba(40, 199, 111, 0.3) !important; font-size: 11.5px;">Active</span>'
                    : '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(234, 84, 85, 0.15) !important; color: #d63031 !important; border: 1px solid rgba(234, 84, 85, 0.3) !important; font-size: 11.5px;">Inactive</span>';
            })
            ->addColumn('action', 'admin.menu_settings.pages_action')
            ->rawColumns(['icon', 'module_id', 'sub_module_id', 'status', 'action']);
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

        if ($request->filled('module_id') && $request->module_id !== 'undefined') {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.module_id', $request->module_id)
                  ->orWhere('sub_modules.module_id', $request->module_id);
            });
        }
        if ($request->filled('sub_module_id') && $request->sub_module_id !== 'undefined') {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.sub_module_id', $request->sub_module_id)
                  ->orWhere('sub_modules.id', $request->sub_module_id);
            });
        }
        if ($request->filled('name') && $request->name !== 'undefined') {
            $query->where(function ($q) use ($request) {
                $q->orWhere('pages.name', 'ilike', '%'.$request->name.'%')
                  ->orWhere('pages.name_kh', 'ilike', '%'.$request->name.'%');
            });
        }

        return $query->selectRaw("pages.id, pages.icon, pages.name, pages.name_kh, pages.status, pages.sort_order,
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
                    ->minifiedAjax()
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
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
            Column::make('icon')->title(__('Icon'))->width(100)->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('name')->title(__('Page Name')),
            Column::make('name_kh')->title(__('Page Name (KH)')),
            Column::make('module_id', 'modules.name')->title(__('Module Name'))->orderable(false)->searchable(false),
            Column::make('sub_module_id', 'sub_modules.name')->title(__('Sub Module Name'))->orderable(false)->searchable(false),
            Column::make('sort_order')->title(__('Order'))->width(80)->addClass('text-center'),
            Column::make('status')->title(__('Status'))->width(90)->addClass('text-center'),
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
