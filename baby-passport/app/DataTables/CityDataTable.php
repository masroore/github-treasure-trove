<?php

namespace App\DataTables;

use App\Models\City;
use DB;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
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
            ->rawColumns(['image', 'rating', 'status', 'action'])
            ->editColumn('image', function ($data) {
                if ($data->image == null) {
                    return '<i class="fas fa-image text-ce-soir fa-2x"></i>';
                }

                return '<img class="img-fluid mx-auto d-block" style="height:60px;width:60px; border-radius:50%;" src="' . asset('storage/cities/' . $data->image) . '">';
            })
            ->editColumn('rating', function ($data) {
                $rating = '';
                for ($i = 0; $i < $data->rating; ++$i) {
                    $rating .= '<i class="fas fa-star text-selective-yellow"></i>';
                }

                return $rating;
            })
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
            ->addColumn('action', 'panel.cities.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(City $model)
    {
        return $model->newQuery()
            ->select(
                'city.id',
                DB::raw('count(hospital.id) as locations'),
                DB::raw('round(avg(rating.star_number)) as rating'),
                'image',
                'copy',
                'bg_image',
                'city.city',
                'city.created_at',
                'city.updated_at',
                'city.status'
            )
            ->join('hospital', 'hospital.city_id', '=', 'city.id')
            ->join('rating', 'rating.id', '=', 'hospital.rating_id', 'left outer')
            ->groupBy('city.id');
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
                'scrollX' => true,
                'responsive' => true,
                'order' => [
                    [1, 'asc'],
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
            'Imagen' => ['name' => 'image', 'data' => 'image', 'class' => 'text-center'],
            'Ciudad' => ['name' => 'city', 'data' => 'city'],
            'Locaciones' => ['name' => 'locations', 'data' => 'locations', 'class' => 'text-center'],
            'Rating' => ['name' => 'rating', 'data' => 'rating', 'class' => 'text-center', 'width' => '150px'],
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
        return 'cities_' . date('YmdHis');
    }
}
