<?php

namespace App\DataTables;

use App\Models\Tag;
use Yajra\DataTables\Services\DataTable;

class TagDataTable extends DataTable
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
            ->rawColumns(['status', 'action'])
            ->editColumn('status', function ($data) {
                $color = $data->status == 1 ? 'success' : 'danger';
                $text = $data->status == 1 ? 'activada' : 'desactivada';

                return '<span class="badge badge-' . $color . '">' . $text . '</span>';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d F Y h:i a');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('d F Y h:i a');
            })
            ->addColumn('action', 'panel.tags.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Tag $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tag $model)
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
            'Etiqueta' => ['name' => 'tag', 'data' => 'tag'],
            'Status' => ['name' => 'status', 'data' => 'status'],
            'Fecha de creación' => ['name' => 'created_at', 'data' => 'created_at'],
            'Última actualización' => ['name' => 'updated_at', 'data' => 'updated_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Tag_' . date('YmdHis');
    }
}
