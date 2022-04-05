<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Packages;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function show($categoria)
    {
        $packages = Packages::where('categories_id', '=', $categoria)->paginate(8);

        /* $packages = Packages::where('categories_id', '=' , $categoria )->paginate(8);

        dd(  $cate = DB::table('packages')
                           ->leftjoin('categories', 'packages.categories_id', '=' , 'categories.id')
                           ->get() );


  $packages = Packages::leftjoin('categories', 'packages.categories_id', '=' , 'categories.id')
                              ->where('categories_id', '=' , $categoria )
                              ->paginate(8); */

        return view('categorias.show', compact('packages', 'categoria'));
    }
}
