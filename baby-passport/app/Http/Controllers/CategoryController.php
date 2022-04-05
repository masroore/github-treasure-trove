<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDatatable;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryDatatable $tagsDataTable)
    {
        return $tagsDataTable->render('panel.categories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            Category::create($request->all());

            return response()->json(['message' => 'Categoría registrada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al registrar la categoría ', $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            return response()->json(['message' => 'No se encontró la categoría'], 404);
        }

        try {
            $category->update($request->all());

            return response()->json(['message' => 'Categoría actualizada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar la categoría' . $e->getMessage()], 500);
        }
    }

    /**
     * Change the category status.
     *
     * @param  int $id
     * @param  int $status
     *
     * @return \Illuminate\Http\Response
     */
    public function setStatus($id, $status)
    {
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json(['msg' => 'Categoría no encontrada'], 404);
        }

        $category->status = $status;
        $category->save();

        $textStatus = $status == 1 ? 'activada' : 'desactivada';

        return response()->json(['message' => 'Categoría ' . $textStatus . ' correctamente'], 200);
    }
}
