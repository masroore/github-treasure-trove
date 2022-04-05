<?php

namespace Modules\AdminInventry\Http\Controllers;

use App\Models\Inventry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminInventryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'inventryList',
        ];
        $inventries = Product::leftjoin('inventry', 'inventry.products_id', '=', 'products.id')
            ->select(['products.id', 'products.image', 'products.sku', 'inventry.available', 'products.name', 'inventry.alert_qty'])
            ->orderByDesc('products.id')->paginate(10);

        return view('admininventry::admininventry.index', compact('inventries'), $data);
    }

    public function addSetAvailability(Request $request): void
    {
        $type_inventry = ($request->type && 'true' == $request->type) ? 1 : 0;
        $product_id = $request->product_id;
        $available = $request->available;
        $alert_qty = $request->alert_qty;

        // check if available the data or not
        $inventryData = Inventry::where('products_id', $product_id)->count();

        if (!$inventryData) {
            $sinventry = new Inventry();
            $sinventry->products_id = $product_id;
            $sinventry->available = $available;
            $sinventry->alert_qty = $alert_qty;
            $sinventry->save();

            echo json_encode(['available' => $available, 'alert_qty' => $alert_qty]);
            exit();
        }
        $productInventryData = Inventry::where('products_id', $product_id)->first()->available;

        // Add the value in the current  available stock
        if ($type_inventry) {
            $current_available = $available + $productInventryData;
            Inventry::where('products_id', $product_id)->first()->update(['available' => $current_available, 'alert_qty' => $alert_qty]);

            echo json_encode(['available' => $current_available, 'alert_qty' => $alert_qty]);
            exit();
        }
        Inventry::where('products_id', $product_id)->first()->update(['available' => $available, 'alert_qty' => $alert_qty]);

        echo json_encode(['available' => $available, 'alert_qty' => $alert_qty]);
        exit();

        exit();
    }
}
