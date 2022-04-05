<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\Module;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ModulesDataTable extends DataTable
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
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Module $module) {
            return view('modules.action', compact('module'));
        })
            ->editColumn('created_at', function ($request) {
            return UtilityFacades::date_time_format($request->created_at);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\module $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(module $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('modules-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                'paginate' => [
                    'next' => '<i class="fas fa-angle-right"></i>',
                    'previous' => '<i class="fas fa-angle-left"></i>',
                ],
            ])
            ->parameters([
                'dom' => "
                                <'row'<'col-sm-12'><'col-sm-9 text-left'B><'col-sm-3'f>>
                                <'row'<'col-sm-12'tr>>
                                <'row mt-3'<'col-sm-5'i><'col-sm-7'p>>
                                ",
                'buttons' => [
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_module', 'action' => " function ( e, dt, node, config ) {
                        window.location = '" . route('modules.create') . "';
                   }"],
                    ['extend' => 'export', 'className' => 'btn btn-primary btn-sm no-corner'],
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-sm no-corner'],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-sm no-corner'],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-sm no-corner'],
                    ['extend' => 'pageLength', 'className' => 'btn btn-danger btn-sm no-corner'],
                ],
                'scrollX' => true,
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

            Column::make('id'),
            Column::make('name'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Modules_' . date('YmdHis');
    }
}
