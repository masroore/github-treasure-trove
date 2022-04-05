<?php

namespace App\Http\Controllers;

use App\DataTables\AdvertisingDataTable;
use App\Http\Requests\CreateAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Models\Advertising;
use DB;
use Illuminate\Database\QueryException;
use Storage;

class AdvertisingController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of ads.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdvertisingDataTable $adsDatatable)
    {
        return $adsDatatable->render('panel.ads.index');
    }

    public function create($id = null)
    {
        if ($id != null) {
            $ad = Advertising::find($id);
            if (empty($ad)) {
                abort(404, 'Publicidad no encontrada');
            }

            return view('panel.ads.create')
                ->with('ad', $ad);
        }

        return view('panel.ads.create');
    }

    public function store(CreateAdRequest $request)
    {
        try {
            DB::beginTransaction();

            $posterImage = $request->file('image');

            Advertising::create([
                'title' => $request['title'],
                'content' => $request['content'],
                'image' => $posterImage->getClientOriginalName(),
                'url' => $request['url'],
                'published_at' => $request['published_at'],
                'expires_at' => $request['expires_at'],
            ]);

            Storage::put('public/sad/' . $posterImage->getClientOriginalName(), file_get_contents($posterImage));

            DB::commit();

            return response()->json(['message' => 'Ad registrado correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Ocurrió un error al registrar el ad' . $e->getMessage()], 500);
        }
    }

    public function update($id, UpdateAdRequest $request)
    {
        try {
            DB::beginTransaction();

            $ad = Advertising::find($id);
            if (empty($ad)) {
                return response()->json(['message' => 'Ad no encontrado'], 404);
            }

            //---CHECK IF A POSTER IMAGE WERE SENT, TO UPDATE IT
            $posterImage = $request->file('image');
            $newPosterImage = $ad->image;
            if ($posterImage != null) {
                Storage::delete('public/sad/' . $ad->image);
                Storage::put('public/sad/' . $posterImage->getClientOriginalName(), file_get_contents($posterImage));
                $newPosterImage = $posterImage->getClientOriginalName();
            }

            $ad->update([
                'title' => $request['title'],
                'content' => $request['content'],
                'image' => $newPosterImage,
                'url' => $request['url'],
                'published_at' => $request['published_at'],
                'expires_at' => $request['expires_at'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Ad actualizado correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Hubo un error al actualizar el ad'], 500);
        }
    }

    public function deleteImage($id)
    {
        $ad = Advertising::find($id);
        if (empty($ad)) {
            return response()->json(['msg' => 'Ad no encontrado'], 404);
        }

        try {
            Storage::delete('public/blogs/' . $ad->image);

            $ad->update([
                'image' => null,
            ]);

            return response()->json(['message' => 'Imagen eliminada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al eliminar la imagen'], 500);
        }
    }
}
