<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Groups::all()->except('created_at', 'updated_at');

            return view('manager_services.categories.index', compact('categories'));
        } catch (Throwable $th) {
            Log::error('Grupos - Index -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:groups'],
            'img' => ['required', 'mimes:jpeg,png'],
        ]);

        try {
            if ($validate) {
                $path = $request->file('img')->store(
                    'groups'
                );

                $group = Groups::create($request->all());

                $group->img = $path;
                $group->save();

                return redirect()->back()->with('msj-success', 'Nuevo Grupo Creada');
            }
        } catch (Throwable $th) {
            Log::error('Grupos - store -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Groups::find($id)->only('name', 'description', 'id', 'status', 'img');
            $category['img'] = asset('media/' . $category['img']);

            return json_encode($category);
        } catch (Throwable $th) {
            Log::error('Grupos - edit -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Groups::find($id);
        if ($category->name != $request->name) {
            $validate = $request->validate([
                'name' => ['required', 'unique:groups'],
            ]);
        } else {
            $validate = true;
        }

        if ($request->file('img')) {
            $validate = $request->validate([
                'img' => ['required', 'mimes:jpeg,png'],
            ]);
        }

        try {
            if ($validate) {
                $category->name = $request->name;
                $category->status = $request->status;
                $category->description = $request->description;
                if ($request->file('img')) {
                    $path = $request->file('img')->store(
                        'groups'
                    );
                    $category->img = $path;
                }
                $category->save();

                return redirect()->back()->with('msj-success', 'Grupo ' . $id . ' Actualizada ');
            }
        } catch (Throwable $th) {
            Log::error('Grupos - update -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Groups::find($id)->delete();

            return redirect()->back()->with('msj-success', 'Grupo ' . $id . ' Eliminada');
        } catch (Throwable $th) {
            Log::error('Grupos - destroy -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }
}
