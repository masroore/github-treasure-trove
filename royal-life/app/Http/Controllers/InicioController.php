<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Categories;
use App\Models\Packages;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function home()
    {
        if (Auth::user() == true) {
            $categorias = Categories::all();
            $productosMasVendidos = Packages::take(9)->get();
            $productos = Packages::take(8)->get();

            $user = Auth::id();
            $ProductosEnCarrito = Cart::where('iduser', $user)->count();

            return view('backofice.home', compact('categorias', 'productos', 'productosMasVendidos', 'ProductosEnCarrito'));
        }

        $categorias = Categories::all();
        $productosMasVendidos = Packages::take(9)->get();
        $productos = Packages::take(8)->get();

        return view('backofice.home', compact('categorias', 'productos', 'productosMasVendidos'));

        /*  if (Auth::user()->admin == 1) {
          return redirect()->route('home');
          } else {
          return redirect()->route('home.user');
          } */
    }
}
