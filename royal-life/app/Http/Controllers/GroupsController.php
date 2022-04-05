<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $categories = Categories::all()->except('created_at', 'updated_at');

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

      //  dd($request);
        $request->validate([
            'name' => ['required', 'unique:categories'],
            'img' => ['required', 'mimes:jpeg,png'],
        ]);

        try {
            if ($request->hasFile('img')) {
                $path = $request->file('img');
                $name = $path->getClientOriginalName();
                $path->move(public_path('storage') . '/photo-profile', $name);
                $group = Categories::create($request->all());
                $group->img = $name;
                $group->save();

                return redirect()->back()->with('msj-success', 'Nueva Categoria Creada');
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
            $category = Categories::find($id)->only('name', 'description', 'id', 'status', 'img');
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
        $user = User::find(Auth::user()->id);
        $category = Categories::find($id);
        $category->update($request->all());
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
                if ($request->hasFile('img')) {
                    $file = $request->file('img');
                    $name = $user->id . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage') . '/photo-profile', $name);
                    $category->img = $name;
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
            Categories::find($id)->delete();

            return redirect()->back()->with('msj-success', 'Grupo ' . $id . ' Eliminada');
        } catch (Throwable $th) {
            Log::error('Grupos - destroy -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }
}
