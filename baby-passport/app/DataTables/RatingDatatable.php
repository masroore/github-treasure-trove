<?php

namespace App\DataTables;

use App\Models\Rating;
use Yajra\DataTables\Services\DataTable;

class RatingDatatable extends DataTable
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
            ->rawColumns(['star_number', 'action'])
            ->editColumn('star_number', function ($data) {
                $stars = '';
                for ($i = 0; $i < $data->star_number; ++$i) {
                    $stars .= '<i class="fas fa-star text-selective-yellow">';
                }

                return $stars;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d F Y h:i a');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('d F Y h:i a');
            })
            ->addColumn('action', 'panel.ratings.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Rating $model)
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
                    [1, 'asc'],
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
            'Rating' => ['name' => 'rating_description', 'data' => 'rating_description', 'class' => 'text-center'],
            'Estrellas' => ['name' => 'star_number', 'data' => 'star_number', 'class' => 'text-center'],
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
        return 'Rating_' . date('YmdHis');
    }
}
