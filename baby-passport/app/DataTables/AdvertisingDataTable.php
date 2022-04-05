<?php

namespace App\DataTables;

use App\Models\Advertising;
use Yajra\DataTables\Services\DataTable;

class AdvertisingDataTable extends DataTable
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
            ->rawColumns(['image', 'status', 'action'])
            ->editColumn('published_at', function ($data) {
                return $data->published_at->format('d F Y h:i a');
            })
            ->editColumn('expires_at', function ($data) {
                if ($data->expires_at != null) {
                    return $data->expires_at->format('d F Y h:i a');
                }

                return 'NA';
            })
            ->editColumn('image', function ($data) {
                if ($data->image == null) {
                    return '<i class="fas fa-image text-ce-soir fa-2x"></i>';
                }

                return '<img class="img-fluid mx-auto d-block" style="height:60px;width:60px; border-radius:50%;" src="' . asset('storage/sad/' . $data->image) . '">';
            })
            ->editColumn('status', function ($data) {
                $color = $data->status == 1 ? 'success' : 'danger';
                $text = $data->status == 1 ? 'publicado' : 'cancelado';

                return '<span class="badge badge-' . $color . '">' . $text . '</span>';
            })
            ->addColumn('action', 'panel.ads.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Advertising $model)
    {
        $ads = $model->newQuery()
            ->select('id', 'title', 'image', 'published_at', 'expires_at', 'status');

        return $ads;
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
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Ver Todos']],
                'pagingType' => 'full_numbers',
                'dom' => 'lBfrtip',
                'scrollX' => false,
                'order' => [
                    [3, 'desc'],
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
            'Imagen' => ['name' => 'image', 'data' => 'image', 'class' => 'text-center'],
            'Título' => ['name' => 'title', 'data' => 'title'],
            'Fecha de publicación' => ['name' => 'published_at', 'data' => 'published_at', 'class' => 'text-center'],
            'Fecha de expiración' => ['name' => 'expires_at', 'data' => 'expires_at', 'class' => 'text-center'],
            'Status' => ['name' => 'status', 'data' => 'status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Advertising_' . date('YmdHis');
    }
}
