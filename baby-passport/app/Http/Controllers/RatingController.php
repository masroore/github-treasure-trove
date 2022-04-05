<?php

namespace App\Http\Controllers;

use App\DataTables\RatingDatatable;
use App\Http\Requests\CreateRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Rating;
use Illuminate\Database\QueryException;

class RatingController extends Controller
{
    /**
     * Display a listing of ratings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RatingDatatable $ratingDatatable)
    {
        return $ratingDatatable->render('panel.ratings.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRatingRequest $request)
    {
        try {
            Rating::create($request->all());

            return response()->json(['message' => 'Rating registrado correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al registrar el rating ', $e->getMessage()], 500);
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
    public function update(UpdateRatingRequest $request, $id)
    {
        $rating = Rating::find($id);

        if (empty($rating)) {
            return response()->json(['message' => 'No se encontró el rating'], 404);
        }

        try {
            $rating->update($request->all());

            return response()->json(['message' => 'Rating actualizado correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar el rating' . $e->getMessage()], 500);
        }
    }

    /**
     * Change the rating status.
     *
     * @param  int $id
     * @param  int $status
     *
     * @return \Illuminate\Http\Response
     */
    public function setStatus($id, $status)
    {
        $rating = Rating::find($id);
        if (empty($rating)) {
            return response()->json(['msg' => 'Rating no encontrado'], 404);
        }

        $rating->status = $status;
        $rating->save();

        $textStatus = $status == 1 ? 'activado' : 'desactivado';

        return response()->json(['message' => 'Rating ' . $textStatus . ' correctamente'], 200);
    }
}
