<?php

namespace Modules\ExternalShop\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Modules\ExternalShop\Entities\Order;
use Modules\ExternalShop\Http\Requests\OrderRequest;
use Modules\ExternalShop\Import\Shop;

class OrderController extends Controller
{
    public function index(Request $request, $source = null)
    {
        $this->authorize('order.read');

        $orders = Order::when($source, function ($q) use ($source): void {
            $q->whereSource($source);
        })->orderByDesc('confirmed_at')
            ->filterable()
            ->paginate();

        return view('externalshop::orders.index', compact('orders'));
    }

    public function edit($source, $id)
    {
        $order = Order::findOrFail($id);

        return view('externalshop::orders.edit', compact('order'));
    }

    public function update(OrderRequest $request, $source, $id)
    {
        $this->authorize('order.update');

        $order = Order::findOrFail($id);

        $order->update($request->validated());

        $destination = $request->session()->pull('destination', route('admin.externalshop.orders.edit', [$source, $order]));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function reload(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $destination = $request->session()->pull('destination', route('admin.externalshop.orders.index', $order->source));

        try {
            $api = new Shop();
            $shop = $api->init($order->source);
            $externalOrder = $shop->getOrder($order->external_id);

            $order->update($api->makeOrderData($externalOrder, $order->source));

            if ($request->ajax()) {
                return response()->json([
                    'action' => 'redirect',
                    'destination' => $destination,
                ]);
            }

            return redirect()->to($destination)
                ->with('success', trans('notifications.update.success'));
        } catch (Exception $exception) {
        }
        if ($request->ajax()) {
            return response()->json([
                'action' => 'redirect',
                'destination' => $destination,
            ]);
        }

        return redirect()->to($destination)
            ->with('error', trans('notifications.update.success'));
    }

    public function destroy(Request $request, $source, $id)
    {
        $this->authorize('order.delete');

        $order = Order::findOrFail($id);
        $order->delete();

        $destination = $request->session()->pull('destination', route('admin.externalshop.orders.index', $source));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    public function printed($id)
    {
        $this->authorize('order.read');

        $order = Order::findOrFail($id);

        return view('externalshop::orders.print', compact('order'));
    }
}
