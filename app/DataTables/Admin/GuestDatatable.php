<?php

namespace App\DataTables\Admin;

use App\Models\Guest;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GuestDatatable extends DataTable
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
            ->editColumn('guest_code', function ($guest) {
                return '<span class="fw-bold font-monospace text-dark">GST'.sprintf('%04d', $guest->id).'</span>';
            })
            ->editColumn('invitation_code', function ($guest) {
                return '<code class="text-primary font-monospace fw-bold">'.$guest->invitation_code.'</code>';
            })
            ->editColumn('side', function ($guest) {
                $style = $guest->side == 'groom' 
                    ? 'background: rgba(24, 119, 242, 0.12); color: #1877f2;' 
                    : ($guest->side == 'bride' ? 'background: rgba(234, 84, 85, 0.12); color: #ea5455;' : 'background: rgba(255, 159, 67, 0.12); color: #ff9f43;');
                return '<span class="badge rounded-pill px-3 py-1 fw-bold" style="'.$style.'">'.ucfirst($guest->side).'</span>';
            })
            ->editColumn('table_number', function ($guest) {
                return '<span class="badge rounded-pill px-3 py-1 fw-bold" style="background: rgba(108, 117, 125, 0.12); color: #495057;">តុ '.($guest->table_number ?? '-').'</span>';
            })
            ->editColumn('attendance', function ($guest) {
                $style = $guest->attendance == 'attending' 
                    ? 'background: rgba(40, 199, 111, 0.15); color: #1e874b; border: 1px solid rgba(40, 199, 111, 0.3);' 
                    : ($guest->attendance == 'declined' 
                        ? 'background: rgba(234, 84, 85, 0.15); color: #d63031; border: 1px solid rgba(234, 84, 85, 0.3);' 
                        : 'background: rgba(255, 159, 67, 0.15); color: #d35400; border: 1px solid rgba(255, 159, 67, 0.3);');
                return '<span class="badge rounded-pill px-3 py-1 fw-bold" style="'.$style.'">'.ucfirst($guest->attendance).'</span>';
            })
            ->addColumn('action', 'admin.guests.action')
            ->rawColumns(['guest_code', 'invitation_code', 'side', 'table_number', 'attendance', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Guest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guest $model, Request $request)
    {
        $query = $model->newQuery();
        if ($request->filled('name') && $request->name !== 'undefined') {
            $query->where('name', 'ilike', '%'.$request->name.'%');
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
                    ->setTableId('guestdatatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv', 'print', 'pdf'],
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
            Column::computed('guest_code')->title(__('app.guest_id')),
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
        return 'Guest_' . date('YmdHis');
    }
}
