<?php

namespace App\Http\Controllers;

use App\DataTables\TagDataTable;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Database\QueryException;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagDataTable $tagsDataTable)
    {
        return $tagsDataTable->render('panel.tags.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        try {
            Tag::create([
                'tag' => $request['tag'],
            ]);

            return response()->json(['message' => 'Etiqueta registrada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al registrar la etiqueta ', $e->getMessage()], 500);
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
    public function update(UpdateTagRequest $request, $id)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            return response()->json(['message' => 'No se encontró la etiqueta'], 404);
        }

        try {
            $tag->update([
                'tag' => $request['tag'],
            ]);

            return response()->json(['message' => 'Etiqueta actualizada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar la etiqueta' . $e->getMessage()], 500);
        }
    }

    /**
     * Change the tag status.
     *
     * @param  int $id
     * @param  int $status
     *
     * @return \Illuminate\Http\Response
     */
    public function setStatus($id, $status)
    {
        $tag = Tag::find($id);
        if (empty($tag)) {
            return response()->json(['msg' => 'Etiqueta no encontrada'], 404);
        }

        $tag->status = $status;
        $tag->save();

        $textStatus = $status == 1 ? 'activada' : 'desactivada';

        return response()->json(['message' => 'Etiqueta ' . $textStatus . ' correctamente'], 200);
    }
}
