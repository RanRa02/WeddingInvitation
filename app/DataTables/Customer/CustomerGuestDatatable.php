<?php

namespace App\DataTables\Customer;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerGuestDatatable extends DataTable
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
            ->editColumn('name', function ($guest) {
                return '<span class="fw-bold text-dark">'.e($guest->name).'</span>';
            })
            ->editColumn('side', function ($guest) {
                $bg = $guest->side == 'groom' ? 'bg-primary bg-opacity-15 text-primary' : ($guest->side == 'bride' ? 'bg-danger bg-opacity-15 text-danger' : 'bg-warning bg-opacity-15 text-dark');
                return '<span class="badge '.$bg.' rounded-pill px-3 py-1">'.ucfirst($guest->side).'</span>';
            })
            ->editColumn('table_number', function ($guest) {
                return '<span class="badge bg-secondary bg-opacity-15 text-dark rounded-pill px-3 py-1 fw-bold">តុ '.($guest->table_number ?? '-').'</span>';
            })
            ->editColumn('invitation_code', function ($guest) {
                return '<code class="text-primary font-monospace fw-bold">'.$guest->invitation_code.'</code>';
            })
            ->editColumn('attendance', function ($guest) {
                $bg = $guest->attendance == 'attending' ? 'bg-success bg-opacity-15 text-success' : ($guest->attendance == 'declined' ? 'bg-danger bg-opacity-15 text-danger' : 'bg-warning bg-opacity-15 text-dark');
                return '<span class="badge '.$bg.' rounded-pill px-3 py-1">'.ucfirst($guest->attendance).'</span>';
            })
            ->addColumn('action', 'customer.guests.action')
            ->rawColumns(['name', 'side', 'table_number', 'invitation_code', 'attendance', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Guest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guest $model, Request $request)
    {
        $query = $model->newQuery()->where('user_id', Auth::id());
        if ($request->name) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        return $query->select(['guests.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('customerguestdatatable')
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
                                $("#customerguestdatatable").DataTable().ajax.reload();
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
            Column::make('name')->title(__('app.guest_name')),
            Column::make('side')->title(__('app.side')),
            Column::make('table_number')->title(__('app.table_no')),
            Column::make('invitation_code')->title(__('app.invitation_code')),
            Column::make('attendance')->title(__('app.rsvp')),
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
        return 'Customer_Guest_' . date('YmdHis');
    }
}
