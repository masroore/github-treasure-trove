<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query results from query() method
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->rawColumns(['type', 'action'])
            ->editColumn('type', function ($data) {
                if ($data->type == 'pacient') {
                    return "<span class='badge badge-ce-soir'>Mamá</span>";
                }

                if ($data->type == 'main_doctor') {
                    return "<span class='badge badge-ice-cold text-light'>Suscripción</span>";
                }

                return "<span class='badge badge-danger text-light'>Administrador</span>";
            })
            ->addColumn('action', 'panel.users.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $userType = $this->request()->get('user_type');
        $from = $this->request()->get('from');
        $to = $this->request()->get('to');
        $step = $this->request()->get('step');

        return $model->newQuery()->when($userType, function ($query) use ($userType): void {
            $query->where('type', $userType);
        })
            ->when($step, function ($query) use ($step): void {
                $query->where('step', $step);
            })
            ->when($from && $to, function ($query) use ($from, $to): void {
                $carbonFrom = Carbon::createFromFormat('Y-m-d', $from);
                $carbonTo = Carbon::createFromFormat('Y-m-d', $to);

                $query->whereBetween('created_at', [$carbonFrom->startOfDay(), $carbonTo->endOfDay()]);
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '200px'])
            ->parameters([
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json',
                ],
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Ver Todas']],
                'pagingType' => 'full_numbers',
                'dom' => 'lBfrtip',
                'scrollX' => false,
                'order' => [
                    [0, 'asc'],
                ],
                'buttons' => [
                    ['extend' => 'reload', 'text' => "<i class='fa fa-refresh'></i> Recargar"],
                ],
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
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Correo Electrónico' => ['name' => 'email', 'data' => 'email'],
            'Tipo Usuario' => ['name' => 'type', 'data' => 'type'],
            'Etapa' => ['name' => 'step', 'data' => 'step'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
