<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Categories::all()->where('status', 1);

            return view('manager_services.services.index', compact('categories'));
        } catch (Throwable $th) {
            Log::error('Packages - index -> Error: ' . $th);
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
        try {
            $categories = Categories::all()->where('status', 1);
            if (!empty(request()->category)) {
                $category = Categories::find(request()->category);
                $services = $category->getPackage;
                $name_category = $category->name;
                $idgrupo = $category->id;
            }
            $id = $category->id;

            $paquetes = Packages::where('categories_id', '=', $idgrupo)->first();

            return view('manager_services.services.create', compact('categories', 'services', 'name_category', 'idgrupo', 'paquetes', 'id'));
        } catch (Throwable $th) {
            Log::error('Packages - create -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => ['required'],
            'categories_id' => ['required'],
            //   'expired' => ['required', 'date'],
            'price' => ['required', 'numeric'],
            'precio_rebajado' => ['required', 'numeric'],
            'img' => ['required', 'mimes:jpeg,png'],
        ]);

        $path = $request->file('img');

        $name = $path->getClientOriginalName();
        $path->move(public_path('storage') . '/photo-producto', $name);

        try {
            if ($validate) {
                $paquete = Packages::create($request->all());
                $paquete->img = $name;
                $paquete->save();
                $route = route('products.package-list') . '?category=' . $request->categories_id;

                return redirect($route)->with('msj-success', 'Nuevo producto creado');
            }
        } catch (Throwable $th) {
            Log::error('Packages - store -> Error: ' . $th);
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
            $service = Packages::find($id);
            $category = $service->categories_id;
            $service->delete();
            $route = route('products.package-list') . '?category=' . $category;

            return redirect($route)->with('msj-success', 'Servicio ' . $id . ' Eliminado');
        } catch (Throwable $th) {
            Log::error('Packages - destroy -> Error: ' . $th);
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
        try {
            $service = Packages::find($id);

            return $service->description;
        } catch (Throwable $th) {
            Log::error('Packages - show -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
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
            $category = Packages::find($id);

            return json_encode($category);
        } catch (Throwable $th) {
            Log::error('Packages - edit -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'categories_id' => ['required'],
            'price' => ['required', 'numeric'],
            'precio_rebajado' => ['required', 'numeric'],
            'img' => ['required', 'mimes:jpeg,png'],
        ]);
        $path = $request->file('img');

        $name = $path->getClientOriginalName();
        $path->move(public_path('storage') . '/photo-producto', $name);

        try {
            if ($validate) {
                $service = Packages::find($id);
                $service->name = $request->name;
                $service->categories_id = $request->categories_id;
                $service->img = $name;
                $service->price = $request->price;
                $service->precio_rebajado = $request->precio_rebajado;
                $service->status = $request->status;
                $service->description = $request->description;
                $service->update();
                $route = route('products.package-list') . '?category=' . $request->group_id;

                return redirect($route)->with('msj-success', 'Servicio ' . $id . ' Actualizado ');
            }
        } catch (Throwable $th) {
            Log::error('Packages - update -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    public function package()
    {
        $package = Packages::all();
        $categories = Categories::all();

        return view('shop.package-list', compact('package', 'categories'));
    }
}
