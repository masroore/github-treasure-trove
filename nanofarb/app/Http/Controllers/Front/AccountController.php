<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\AccountRequest;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:client-account.read'/*, 'verified'*/]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('front.account.edit', compact('user'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(AccountRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('name', 'last_name', 'email', 'phone', 'birthday', 'subscriber', 'contact_id', 'data'));

        if ($request->get('password')) {
            $user->setAttribute('password', Hash::make($request->password));
            $user->setAttribute('data->password', '');
        }

        //$contact = array_merge($request->contact, [
        //    'name' => $user->full_name,
        //    'email' => $user->email,
        //    'phone' => $user->phone,
        //]);
        //if ($request->has('contact_id')) {
        //    $contactDb = $user->contacts->where('id', $request->contact_id)->first();
        //    $contactDb->update(array_merge($contactDb->toArray(), $contact));
        //} else {
        //    $contact = $user->contacts()->create($contact);
        //    $user->contact_id = $contact->id;
        //}
        $user->save();

        $destination = $request->session()->pull('destination', route('account.edit'));
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                //'message' => trans('notifications.update.success'),
                'action' => 'redirect',
                'destination' => $destination,
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('products.media', 'products.group.product.media', 'products.values')
            ->orderBy('id', 'desc')
            ->whereType(Order::TYPE_ORDER)->get();

        return view('front.account.history', compact('orders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favorites(Request $request)
    {
        $user = $request->user();

        $products = Product::with('group.product.media', 'media', 'values')
            ->isPublish()->whereIn('id', $user->productFavorites->pluck('id')->toArray())->get();

        return view('front.account.favorites', compact('products'));
    }
}
