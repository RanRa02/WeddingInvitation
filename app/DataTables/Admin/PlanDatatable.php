<?php

namespace App\DataTables\Admin;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PlanDatatable extends DataTable
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
            ->editColumn('name', function ($plan) {
                return '<strong class="text-dark fs-6">'.$plan->name.'</strong><small class="text-muted d-block">'.$plan->slug.'</small>';
            })
            ->editColumn('guest_limit', function ($plan) {
                return '<span class="badge bg-primary bg-opacity-15 text-primary fs-6 px-3 py-1 rounded-pill fw-bold">
                    <i class="fas fa-users me-1"></i> '.number_format($plan->guest_limit).' នាក់
                </span>';
            })
            ->editColumn('price', function ($plan) {
                return '<strong class="text-success fs-5">$'.number_format($plan->price, 2).'</strong>';
            })
            ->editColumn('original_price', function ($plan) {
                return $plan->original_price
                    ? '<span class="text-muted text-decoration-line-through">$'.number_format($plan->original_price, 2).'</span>'
                    : '<span class="text-muted">-</span>';
            })
            ->editColumn('discount_percentage', function ($plan) {
                return $plan->discount_percentage > 0
                    ? '<span class="badge bg-danger bg-opacity-15 text-danger fs-6 px-2 py-1 rounded-pill fw-bold">-'.number_format($plan->discount_percentage, 0).'% Off</span>'
                    : '<span class="text-muted">0%</span>';
            })
            ->editColumn('duration_days', function ($plan) {
                return $plan->duration_days.' ថ្ងៃ';
            })
            ->editColumn('is_active', function ($plan) {
                return $plan->is_active
                    ? '<span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-1">Active</span>'
                    : '<span class="badge bg-secondary bg-opacity-15 text-secondary rounded-pill px-3 py-1">Inactive</span>';
            })
            ->addColumn('action', 'admin.plans.action')
            ->rawColumns(['name', 'guest_limit', 'price', 'original_price', 'discount_percentage', 'is_active', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param SubscriptionPlan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SubscriptionPlan $model, Request $request)
    {
        $query = $model->newQuery();
        if ($request->name) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        return $query->select(['subscription_plans.*']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('plandatatable')
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
                                $("#plandatatable").DataTable().ajax.reload();
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
            Column::make('name')->title(__('app.plan_name')),
            Column::make('guest_limit')->title(__('app.guest_limit')),
            Column::make('price')->title(__('app.price')),
            Column::make('original_price')->title(__('app.original_price')),
            Column::make('discount_percentage')->title(__('app.discount')),
            Column::make('duration_days')->title(__('app.duration_days')),
            Column::make('is_active')->title(__('app.status'))->width(90)->addClass('text-center'),
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
        return 'Plan_' . date('YmdHis');
    }
}
