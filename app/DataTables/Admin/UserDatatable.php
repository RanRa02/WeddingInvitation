<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
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
            ->editColumn('photo', function ($user) {
                return '<div class="rounded-circle bg-warning text-white fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px; font-size: 13px; background: #ff9f43 !important;">
                    '.strtoupper(substr($user->name, 0, 1)).'
                </div>';
            })
            ->editColumn('user_code', function ($user) {
                return '<span class="fw-bold font-monospace text-dark">USR'.sprintf('%04d', $user->id).'</span>';
            })
            ->editColumn('role', function ($user) {
                return $user->role
                    ? '<span class="badge bg-primary bg-opacity-15 text-primary rounded-pill px-3 py-1"><i class="fas fa-user-shield me-1"></i> '.$user->role->name.'</span>'
                    : '<span class="badge bg-secondary bg-opacity-15 text-secondary rounded-pill px-3 py-1">No Role</span>';
            })
            ->editColumn('guest_limit', function ($user) {
                $used = $user->guests()->count();
                $max = $user->guest_limit ?? 100;
                $isMax = $used >= $max;
                $class = $isMax ? 'bg-danger text-white' : 'bg-warning bg-opacity-15 text-dark border';
                return '<span class="badge '.$class.' rounded-pill px-3 py-1 font-monospace fw-bold"><i class="fas fa-address-book me-1"></i> '.$used.' / '.$max.'</span>';
            })
            ->editColumn('status', function ($user) {
                return $user->status === 'active'
                    ? '<span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-1">Active</span>'
                    : '<span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-3 py-1">Inactive</span>';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-';
            })
            ->addColumn('action', 'admin.users.action')
            ->rawColumns(['photo', 'user_code', 'role', 'guest_limit', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model, Request $request)
    {
        $query = $model->newQuery()->with('role');
        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->name.'%')
                  ->orWhere('email', 'like', '%'.$request->name.'%');
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $query->select(['users.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('userdatatable')
                    ->columns($this->getColumns())
                    ->ajax([
                        'data' => 'function(d) {
                            d.name = $("#name").val();
                            d.status = $("#status").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
                        'initComplete' => 'function() {
                            $("#filter").submit(function(event) {
                                event.preventDefault();
                                $("#userdatatable").DataTable().ajax.reload();
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
            Column::computed('photo')->title(__('app.photo'))->width(50)->addClass('text-center'),
            Column::computed('user_code')->title(__('app.user_id')),
            Column::make('name')->title(__('app.user_name')),
            Column::make('email')->title(__('app.email')),
            Column::computed('role')->title(__('app.role')),
            Column::computed('guest_limit')->title(__('app.guest_limit')),
            Column::make('status')->title(__('app.status'))->width(90)->addClass('text-center'),
            Column::make('created_at')->title(__('app.created_date')),
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
        return 'User_' . date('YmdHis');
    }
}
