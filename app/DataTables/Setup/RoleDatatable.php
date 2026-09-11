<?php

namespace App\DataTables\Setup;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDatatable extends DataTable
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
            ->editColumn('role_id', function ($role) {
                return '<span class="fw-bold font-monospace text-dark">ROL'.sprintf('%04d', $role->id).'</span>';
            })
            ->editColumn('name', function ($role) {
                return '<div class="fw-bold text-dark">'.$role->name.'</div>';
            })
            ->editColumn('slug', function ($role) {
                return '<span class="badge bg-primary bg-opacity-15 text-primary rounded-pill px-3 py-1 font-monospace">'.$role->slug.'</span>';
            })
            ->editColumn('users_count', function ($role) {
                return '<span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-bold">
                    <i class="fas fa-users text-primary me-1"></i> '.$role->users_count.' Users
                </span>';
            })
            ->addColumn('action', 'admin.menu_settings.roles_action')
            ->rawColumns(['role_id', 'name', 'slug', 'users_count', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model, Request $request)
    {
        $query = $model->newQuery()->withCount('users');
        if ($request->name) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        return $query->select(['roles.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('roledatatable')
                    ->columns($this->getColumns())
                    ->ajax([
                        'data' => 'function(d) {
                            d.name = $("#name").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                        'initComplete' => 'function() {
                            $("#filter").submit(function(event) {
                                event.preventDefault();
                                $("#roledatatable").DataTable().ajax.reload();
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
            Column::computed('role_id')->title(__('app.role_id')),
            Column::make('name')->title(__('app.role_name')),
            Column::make('slug')->title(__('app.slug')),
            Column::make('description')->title(__('app.description')),
            Column::computed('users_count')->title(__('app.users_count'))->width(100)->addClass('text-center'),
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
        return 'Role_' . date('YmdHis');
    }
}
