<?php

namespace App\DataTables;

use App\Models\Blog;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
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
            ->rawColumns(['poster_image', 'status', 'action'])
            ->editColumn('date_to_publish', function ($data) {
                return $data->date_to_publish->format('d F Y h:i a');
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d F Y h:i a');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('d F Y h:i a');
            })
            ->editColumn('poster_image', function ($data) {
                if ($data->poster_image == null) {
                    return '<i class="fas fa-image text-ce-soir fa-2x"></i>';
                }

                return '<img class="img-fluid mx-auto d-block" style="height:60px;width:60px; border-radius:50%;" src="' . asset('storage/blogs/' . $data->poster_image) . '">';
            })
            ->editColumn('status', function ($data) {
                $color = $data->status == 1 ? 'success' : 'danger';
                $text = $data->status == 1 ? 'publicado' : 'cancelado';

                return '<span class="badge badge-' . $color . '">' . $text . '</span>';
            })
            ->addColumn('action', 'panel.blogs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
    {
        $category = $this->request()->get('category');

        $blogs = $model->newQuery()
            ->select('blog.id', 'category.category', 'blog.title', 'blog.poster_image', 'blog.date_to_publish', 'blog.status')
            ->join('blog_category', 'blog.id', '=', 'blog_category.blog_id')
            ->join('category', 'category.id', '=', 'blog_category.category_id');

        if (!empty($category)) {
            $blogs->where('blog_category.category_id', '=', $category);
        }

        return $blogs;
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
            'Imagen' => ['name' => 'poster_image', 'data' => 'poster_image', 'class' => 'text-center'],
            'Título' => ['name' => 'title', 'data' => 'title'],
            'Categoría' => ['name' => 'category', 'data' => 'category'],
            'Día de publicación' => ['name' => 'date_to_publish', 'data' => 'date_to_publish', 'class' => 'text-center'],
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
        return 'Blog_' . date('YmdHis');
    }
}
