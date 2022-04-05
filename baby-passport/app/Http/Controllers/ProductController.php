<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDatatable;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductDetail;
use DB;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    /**
     * Display a listing of tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDatatable $productDatatable)
    {
        return $productDatatable->render('panel.products.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::create($request['product']);

            $productsQty = count($request['product_detail']['detail']);

            for ($i = 0; $i < $productsQty; ++$i) {
                $product->details()->create([
                    'detail' => $request['product_detail']['detail'][$i],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Producto registrada correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Hubo un error al registrar el producto ', $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $product = Product::with('details')->find($id);

        if (empty($product)) {
            return response()->json(['message' => 'No se encontró el producto'], 404);
        }

        return response()->json(['product' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response()->json(['message' => 'No se encontró el producto'], 404);
        }

        try {
            DB::beginTransaction();

            $product->update($request['product']);
            $noProducts = count($request['product_detail']['detail']);

            for ($i = 0; $i < $noProducts; ++$i) {
                if ($request['product_detail']['id'][$i]) {
                    $product->details()
                        ->where('id', $request['product_detail']['id'][$i])
                        ->update([
                            'detail' => $request['product_detail']['detail'][$i],
                        ]);
                } else {
                    $product->details()->create([
                        'detail' => $request['product_detail']['detail'][$i],
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Producto actualizada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar el producto' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a product detail.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDetail($id)
    {
        $productDetail = ProductDetail::find($id);
        if (empty($productDetail)) {
            return response()->json(['msg' => 'Detalle no encontrado'], 404);
        }

        try {
            $productDetail->delete();

            return response()->json(['message' => 'Detalle eliminado correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al eliminar el detalle'], 500);
        }
    }
}
