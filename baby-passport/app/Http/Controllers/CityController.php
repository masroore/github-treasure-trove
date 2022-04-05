<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Storage;

class CityController extends Controller
{
    /**
     * Display a listing of cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CityDataTable $cityDataTable)
    {
        return $cityDataTable->render('panel.cities.index');
    }

    public function listHospitals($id)
    {
        $city = City::find($id);

        if (empty($city)) {
            return response()->json(['message' => 'No se encontró la ciudad'], 404);
        }

        $hospitals = $city->hospitals()->select('hospital.id', 'hospital.name', 'rating.star_number')->join('rating', 'hospital.rating_id', '=', 'rating.id')
            ->get();

        return response()->json(['hospitals' => $hospitals], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        try {
            $posterImage = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $bgImage = time() . '_bg.' . $request->file('bg_image')->getClientOriginalExtension();

            City::create([
                'city' => $request['city'],
                'copy' => $request['copy'],
                'image' => $posterImage,
                'bg_image' => $bgImage,
            ]);

            Storage::put('public/cities/' . $posterImage, file_get_contents($request->file('image')));
            Storage::put('public/cities/' . $bgImage, file_get_contents($request->file('bg_image')));

            return response()->json(['message' => 'Ciudad registrada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al registrar la ciudad ', $e->getMessage()], 500);
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
    public function update(UpdateCityRequest $request, $id)
    {
        $city = City::find($id);

        if (empty($city)) {
            return response()->json(['message' => 'No se encontró la ciudad'], 404);
        }

        try {
            $posterImage = $city->image;
            //Replace Poster Image if it comes in the request
            if ($request->file('image') != null) {
                if ($posterImage != null) {
                    Storage::delete('public/cities/' . $posterImage);
                }

                $posterImage = time() . '.' . $request->file('image')->getClientOriginalExtension();
                Storage::put('public/cities/' . $posterImage, file_get_contents($request->file('image')));
            }

            $bgImage = $city->bg_image;
            //Replace Background Web Image if it comes in the request
            if ($request->file('bg_image') != null) {
                if ($bgImage != null) {
                    Storage::delete('public/cities/' . $bgImage);
                }

                $bgImage = time() . '_bg.' . $request->file('bg_image')->getClientOriginalExtension();
                Storage::put('public/cities/' . $bgImage, file_get_contents($request->file('bg_image')));
            }

            $city->update([
                'city' => $request['city'],
                'copy' => $request['copy'],
                'bg_image' => $bgImage,
                'image' => $posterImage,
            ]);

            return response()->json(['message' => 'Ciudad actualizada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar la ciudad' . $e->getMessage()], 500);
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
        $city = City::find($id);
        if (empty($city)) {
            return response()->json(['msg' => 'Ciudad no encontrada'], 404);
        }

        $city->status = $status;
        $city->save();

        $textStatus = $status == 1 ? 'activada' : 'desactivada';

        return response()->json(['message' => 'Ciudad ' . $textStatus . ' correctamente'], 200);
    }

    public function deleteImage($id, $type)
    {
        $city = City::find($id);
        if (empty($city)) {
            return response()->json(['msg' => 'Ciudad no encontrada'], 404);
        }

        try {
            Storage::delete('public/cities/' . $city->$type);

            $city->update([
                $type => null,
            ]);

            return response()->json(['message' => 'Imagen eliminada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al eliminar la imagen'], 500);
        }
    }
}
