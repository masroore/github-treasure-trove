<?php

namespace App\Http\Controllers\Front\Shop;

use App\Events\Shop\OrderConfirmed;
use App\Helpers\Currency\Facades\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Shop\OrderNowRequest;
use App\Http\Requests\Front\Shop\ShippingCartFormRequest;
use App\Http\Requests\Front\Shop\ShoppingCartCartOrderRequest;
use App\Managers\OrderManager;
use App\Managers\UserManager;
use App\Models\Shop\Attribute;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\Shop\Sale;
use App\Models\Shop\SalePromoCode;
use App\Models\Shop\Value;
use App\Models\User;
use App\Services\Cdek;
use Cart;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use URL;
use UrlAliasLocalization;

class ShoppingCartController extends Controller
{
    protected $orderManager;

    protected $userManager;

    protected $productTiningId;

    /**
     * ShoppingCartController constructor.
     */
    public function __construct(OrderManager $orderManager, UserManager $userManager)
    {
        $this->orderManager = $orderManager;

        $this->userManager = $userManager;
    }

    /**
     * Show products in cart.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        [$cart, $purchase, $delivery] = $this->getCartData($request);
        $recommends = $this->getRecommendationProduct($cart['products']);

        foreach ($cart['products'] as $product) {
            $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
                return $this->productTiningId = $attribute->id;
            });
        }
        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('front.shopping-cart.inc.cart-content', compact('user', 'cart', 'purchase', 'delivery'))->render(),
            ]);
        }

        return view('front.shopping-cart.index', compact('cart', 'purchase', 'tining', 'delivery', 'recommends'));
    }

    /**
     * Add product to cart.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, $id, $amount = 1, $color = null)
    {
        $color_id = $request->color_id;
        $product = Product::isPublish()->findOrFail($id);
        Cart::add($product->id, $request->get('quantity', $amount), $color_id);
        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Товар добавлен в корзину',
                //'html' => view('front.products.inc.modal-cart')->render(),
                'html' => Cart::count(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    public function addToCart(Request $request, $id, $amount = 1, $color = null)
    {
        $product = Product::isPublish()->findOrFail($request->get('productId'));

        Cart::add($product->id, $request->get('quantity', $amount), $request->get('colorId'));

        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Товар добавлен в корзину',
                //'html' => view('front.products.inc.modal-cart')->render(),
                'html' => Cart::count(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Remove product from the Order-cart.
     *
     * @param $id
     *
     * @return int
     */
    public function remove(Request $request, $id, $amount, $color)
    {
        $product = Product::isPublish()->findOrFail($id);

        if (!Cart::remove($product->id, $amount)) {
            // Product does not exists in the cart in needed count
        }

        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Товар удален с корзины',
                //'action' => 'redirect',
                //'html' => view('front.products.inc.modal-favorites')->render(),
                'destination' => $destination,
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function clear(Request $request)
    {
        Cart::clear();

        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.store.success'),
                'action' => 'redirect',
                'destination' => $destination,
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Save & confirm order.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function order(ShoppingCartCartOrderRequest $request)
    {
        if (Auth::check()) {
            // Пользователь авторизован
            $user = Auth::user();
//            \cookie()->forget('uuid');
        } elseif ($user = User::where('email', $request->input('data.delivery.email') ?: '0')->orWhere('phone', $request->input('data.delivery.phone') ?: '0')->first()) {
            // Пользователь с указанным емейл/телефоному уже есть в БД, ему и будет заказ
//            \Cart::setCurrentUserId($user->id)->merge(['eloquent', 'cookie']);
//            \Cart::storage('eloquent');
            $request->session()->put('destination', route('home'));
        } else {
            // Создаем нового пользователя и логинем его
//            Cookie::queue(Cookie::forget('uuid'));
            $user = $this->userManager->create($request->input('data.delivery.name'), $request->input('data.delivery.email'), $request->input('data.delivery.phone'));
            Auth::loginUsingId($user->id, true);
            Cart::storage('eloquent');
        }

        if (empty($user->phone)) {
            $user->phone = $request->input('data.delivery.phone');
            $user->save();
        }

        [$cart, $purchase, $delivery, $sales] = $this->getCartData($request);

        $deliveryData = [
            'method' => $request->input('data.delivery.method'),
            'name' => $request->input('data.delivery.name'),
            'email' => $request->input('data.delivery.email'),
            'phone' => $request->input('data.delivery.phone'),
            'city' => $request->input('data.delivery.city'),
            'price' => $delivery['price'],
        ];

        if ($request->input('data.delivery.method') == 'novaposhta') {
            $deliveryData['pvz'] = $request->input('data.delivery.pvz');
            $deliveryData['tariff'] = $request->input('data.delivery.tariff');
            $deliveryData['address'] = $request->input('data.delivery.address');
        } elseif ($request->input('data.delivery.method') == 'pickup') {
            $deliveryData['address'] = variable('delivery_pickup_address');
        }

        $identyUser = Cookie::get('uuid') ? null : $user->id;
        $identyUuid = Cookie::get('uuid') ?: null;
        $order = Order::firstOrCreate([
            'user_id' => $identyUser,
            'uuid' => $identyUuid,
            'type' => Order::TYPE_CART,
            'status' => 'order_new', // TODO safe status
        ]);

        $order->setAttribute('data->delivery', $deliveryData);
        $order->setAttribute('data->purchase', $purchase);
        $order->setAttribute('data->payment', ['method' => $request->input('data.payment.method')]);
        $order->setAttribute('data->sales', $sales->toArray());  // TODO
        $order->setAttribute('type', Order::TYPE_ORDER);
        $order->setAttribute('ordered_at', \Carbon\Carbon::now());
        $order->setAttribute('locale', UrlAliasLocalization::getCurrentLocale());
        $order->save();

        $codeValue = $request->input('cart.promocode');
        if ($codeValue && ($promoCode = SalePromoCode::isAvailable()->isActive()->where('code', $codeValue)->first())) {
            $promoCode->increment('used_count');
        }
        session()->forget('cart.promocode');
        session()->forget('cart.promocode_info');

        event(new OrderConfirmed($order));

        $destination = $request->session()->pull('destination', route_alias('account.history'));
        $cookie = Cookie::forget('uuid');
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => 'redirect',
                'destination' => $destination,
            ])->withCookie($cookie);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'))->withCookie($cookie);
    }

    public function orderNow(OrderNowRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;

        if (Auth::check()) {
            // залогиненый пользователь
            $user = Auth::user();
        } elseif ($existingUser = User::where('email', $email ?? '-')->orWhere('phone', $phone ?? '-')->first()) {
            // существующий пользователь
            $user = $existingUser;
        } else {
            // создаем нового пользователя
            $rawPassword = str_random(8);
            $user = User::create(compact('name', 'email', 'phone') + ['password' => Hash::make($rawPassword)]);
            $user->setAttribute('data->password', $rawPassword);
            $user->save();
            $user->assignRole('client');
            $user->markEmailAsVerified();
        }

        $order = $user->orders()->create([
            'type' => Order::TYPE_ORDER,
            'status' => 'order_new',
            'payment_status' => 'payment_new',
            'ordered_at' => \Carbon\Carbon::now(),
            'locale' => $request->get('locale', UrlAliasLocalization::getCurrentLocale()),
        ]);

        $order->setAttribute('data->delivery', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);

        $order->products()->attach([$product->id => [
            'quantity' => $request->quantity ?? 1,
            'price' => $product->getCalculatePrice('price'), //TODO action price
        ]]);
        $order->save();

        event(new OrderConfirmed($order));

        $destination = $request->session()->pull('destination', URL::previous());

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => 'redirect',
                'destination' => $destination,
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Update product for cart.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    /**
     * Update product color.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getCalculatePriceColor(Product $product, $color)
    {
        if ($color) {
            $color = Value::findOrFail($color);
        }
        $price = $product->getCalculatePrice('price');
        if ($color) {
            $price = $price + ($price * $color->markup);

            return $price;
        }

        return $price;
    }

    public function getCalculateOldPriceColor(Product $product, $color)
    {
        if ($color) {
            $color = Value::findOrFail($color);
        }
        if ($product->getCalculatePrice('price_old')) {
            $priceOldCalc = $product->getCalculatePrice('price_old');
            if ($color) {
                $price = $priceOldCalc + ($priceOldCalc * $color->markup);

                return $price;
            }

            return $priceOldCalc;
        }
    }

    /**
     * Update shopping cart.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function form(ShippingCartFormRequest $request)
    {
        if ($request->has('products')) {
            foreach ($request->products as $id => $data) {
                Cart::update($id, $request->quantity ?? 1, $request->color);
            }
        }

        [$cart, $purchase, $delivery] = $this->getCartData($request);
//        dd($cart);
        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                //'action' => 'redirect',
                //'destination' => $destination,
                'html' => view('front.shopping-cart.inc.cart-form', compact('cart', 'purchase', 'delivery'))->render(),
                //'htmlHeaderCart' => view('front.products.inc.modal-cart')->render(),
                'htmlHeaderCart' => Cart::count(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    protected function getCartData(Request $request)
    {
        $cartProducts = Cart::getIds();
        foreach ($cartProducts as $product) {
            if ($product->pivot->value_id) {
                $product['color'] = Value::where('id', $product->pivot->value_id)->pluck('value')->first();
            } else {
                $product['color'] = '';
            }
        }

        $categoriesIdCartProducts = $cartProducts->pluck('category_id')->toArray();

        $cartSumTotalProducts = [];
        foreach ($cartProducts as $product) {
            $cartSumTotalProducts[] = ($product->pivot->price * $product->pivot->quantity);
        }

        $cartSumTotalProducts = array_sum($cartSumTotalProducts);
//        dd($cartSumTotalProducts);

//        $cartSumTotalProducts = $cartProducts->map(function ($product) use ($productsCounts) {
//            return $product->getCalculatePrice('price') * $productsCounts[$product->id]; // TODO currency
//        })->sum();

        // сумма скидки для товаров (старая/новая цена)
//        $cartSumDiscountProducts = $cartProducts->map(function ($product) use ($productsCounts) {
//            return $product->getCalculatePrice('discount') * $productsCounts[$product->id]; // TODO currency
//        })->sum();

        $cartSumDiscountProducts = [];
        foreach ($cartProducts as $product) {
            $cartSumDiscountProducts[] = $product->getCalculatePrice('discount') * $product->pivot->quantity;
        }

        $cartSumDiscountProducts = array_sum($cartSumDiscountProducts);

        $discountSum = 0;

        // премененные промокоды (промокод)
        $promoCodesId = [];
        if ($request->get('remove_promocode')) {
            session()->forget('cart.promocode');
        } elseif ($request->purpose == 'promocode' && ($code = $request->input('cart.promocode'))) {
            session()->put('cart.promocode', $code); // TODO array
            $promoCodesId[] = $code;
        } elseif (session()->get('cart.promocode')) {
            $promoCodesId[] = session()->get('cart.promocode');
        }

        // TODO: refactoring

        $productsIds = [];
        if ($cartProducts) {
            foreach ($cartProducts as $product) {
                $productsIds[] = $product['id'];
            }
        }

        $sales = Sale::isPublish()
            ->select('id', 'name', 'start_at', 'end_at', 'type', 'discount', 'discount_type', 'dateless', 'data')
            ->where(function ($qSales) use ($promoCodesId, $productsIds, $categoriesIdCartProducts): void {
                $qSales
                    // бесплатная доставка
                    ->orWhere('type', Sale::TYPE_FREE_SHIPPING_CONDITIONS)

                    // бесплатная доставка по промокоду
                    ->orWhere(function ($qSales2) use ($promoCodesId): void {
                        $qSales2->where('type', Sale::TYPE_PROM_CODE_FREE_ORDER)
                            ->whereHas('promoCodes', function ($qPromoCodes) use ($promoCodesId): void {
                                $qPromoCodes->whereIn('code', $promoCodesId);
                            });
                    })

                     // скидка на товары
                    ->orWhere(function ($qSales2) use ($productsIds, $categoriesIdCartProducts): void {
                        $qSales2->where('type', Sale::TYPE_PRODUCT)
                            ->whereHas('products', function ($products) use ($productsIds): void {
                                $products->whereIn('model_id', $productsIds);
                            })->orWhereHas('terms', function ($terms) use ($categoriesIdCartProducts): void {
                                $terms->whereIn('model_id', $categoriesIdCartProducts);
                            });
                    })

                    // скидка на продукты по промокоду
                    ->orWhere(function ($qSales2) use ($productsIds, $promoCodesId, $categoriesIdCartProducts): void {
                        $qSales2->where('type', Sale::TYPE_PROM_CODE_PRODUCT)
                            ->whereHas('promoCodes', function ($qPromoCodes) use ($promoCodesId): void {
                                $qPromoCodes->isActive()->whereIn('code', $promoCodesId);
                            })->where(function ($qSales3) use ($productsIds, $categoriesIdCartProducts): void {
                                $qSales3->whereHas('products', function ($products) use ($productsIds): void {
                                    $products->whereIn('model_id', $productsIds);
                                })->orWhereHas('terms', function ($terms) use ($categoriesIdCartProducts): void {
                                    $terms->whereIn('model_id', $categoriesIdCartProducts);
                                });
                            });
                    })
                    // скидка на сумму заказа по промокоду
                    ->orWhere(function ($qSales2) use ($promoCodesId): void {
                        $qSales2->where('type', Sale::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER)
                            ->whereHas('promoCodes', function ($qPromoCodes) use ($promoCodesId): void {
                                $qPromoCodes->whereIn('code', $promoCodesId);
                            });
                    });
            })->get();

        // стоимость доставки
        $delivery['price'] = 0;

        $deliveryMethod = $request->input('data.delivery.method', 'novaposhta');
        //$deliveryCityId = $request->input('data.delivery.city_id', 44);
        //$deliveryTariff = $request->input('data.delivery.tariff', 'pvz');
        //$deliveryPwz = $request->input('data.delivery.pvz');

        if ($deliveryMethod == 'novaposhta') {
            $delivery['price'] = variable('delivery_novaposhta_price', 0) * 100;
        } elseif ($deliveryMethod == 'pickup') {
            $delivery['price'] = 0;
        } elseif ($deliveryMethod == 'courier') {
            $delivery['price'] = variable('delivery_courier_price', 0);
        }

        // Бесплатная доставка с условиями
        if ($sale = $sales->where('type', Sale::TYPE_FREE_SHIPPING_CONDITIONS)->first()) {

            // + учитывать сумму товаров в заказе
            $conditionMinSum = true;
            if (!empty($sale->data['min_sum'])) {
                $conditionMinSum = $sale->data['min_sum'] <= $cartSumTotalProducts;
            }

            // + учитывать доставку до пункта самовывоза (136)
            $conditionDeliveryPwz = true;
            //if (!empty($sale->data['only_delivery_pwz'])) {
            //    $conditionDeliveryPwz = $deliveryTariff == 136;
            //}

            if ($conditionMinSum && $conditionDeliveryPwz) {
                $delivery['price'] = 0;
                $saleInfoMsg[] = $sale->data['msg_after_prepare'] ?? 'Бесплатная доставка c условиями активирована!';
            } else {
                $sales = $sales->whereNotIn('id', $sales->where('type', Sale::TYPE_FREE_SHIPPING_CONDITIONS)->pluck('id')->toArray());
            }
        }

        // Акция на бесплатную доставку по промокоду
        if ($sale = $sales->where('type', Sale::TYPE_PROM_CODE_FREE_ORDER)->first()) {
            //$delivery['price'] = 0;
            $discountSum += $delivery['price'];
            session()->put('cart.promocode_info', $sale->data['msg_after_prepare'] ?? 'Бесплатная доставка активирована!');
        }

        // TODO: Скидка на цену товаров - старая/новая цена
        if ($sales->where('type', Sale::TYPE_PRODUCT)->count()) {
            //session()->put('cart.promocode_info', 'Скидка 10% активирована');
            //\Log::info("Акция на товары\n", $sales->where('type', Sale::TYPE_PRODUCT)->toArray());
        }

        // TODO: Скидка на цену товаров по промокодам
        if ($sales->where('type', Sale::TYPE_PROM_CODE_PRODUCT)->count()) {
            //\Log::info("Акция на товары по промокоду\n", $sales->where('type', Sale::TYPE_PROM_CODE_PRODUCT)->only('id')->toArray());
        }

        // Скидка на сумму заказа по промокоду
        if ($sale = $sales->where('type', Sale::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER)->first()) {
            if ($sale->discount_type == Sale::DISCOUNT_TYPE_SUM) {
                $discountSum += $sale->discount;
            } elseif ($sale->discount_type == Sale::DISCOUNT_TYPE_PERCENT) {
                $discountSum += $cartSumTotalProducts * $sale->discount / 100;
            }

            session()->put('cart.promocode_info', $sale->data['msg_after_prepare'] ?? 'Промокод активирован!');
        }

        $purchase['products'] = $cartSumTotalProducts;
        $purchase['delivery'] = $delivery['price'];
        $purchase['discount'] = $discountSum;
        $purchase['discount_products'] = $cartSumDiscountProducts;
        $purchase['total'] = $cartSumTotalProducts + $delivery['price'] - $discountSum;

        $cart['products'] = $cartProducts;
        $cart['product_counts'] = count($cartProducts);

        return [$cart, $purchase, $delivery, $sales];
    }

    /**
     * @param $productsInCart
     *
     * @return mixed
     */
    protected function getRecommendationProduct($productsInCart)
    {
//        dd(count($productsInCart));
//        return Product::withBase()->isPublish()
//            ->when($productsInCart->count(), function ($p) use ($productsInCart) {
//                $p->whereIn('category_id', $productsInCart->pluck('category_id')->toArray());
//            })
//            ->whereNotIn('id', $productsInCart->pluck('id')->toArray())
//            ->inRandomOrder()
//            ->byLocale()
//            ->limit(10)->get();
        $categoriesIdCartProducts = [];
        $productsIdInCart = [];
        foreach ($productsInCart as $product) {
            $productsIdInCart[] = $product['id'];
            $categoriesIdCartProducts[] = $product['category_id'];
        }

        return Product::withBase()->isPublish()
            ->when(count($productsInCart), function ($p) use ($categoriesIdCartProducts): void {
                $p->whereIn('category_id', $categoriesIdCartProducts);
            })
            ->whereNotIn('id', $productsIdInCart)
            ->inRandomOrder()
            ->byLocale()
            ->limit(10)->get()->unique('product_group_id');
    }

    /**
     * Для модалки.
     *
     * @param $city
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cdekPwz($city, Cdek $cdek)
    {
        $pwzItems = $cdek->getPwz($city);

        return response()->json([
            'html' => view('front.shopping-cart.inc.cdek-pwz-items-for-modal', compact('pwzItems'))->render(),
        ]);
    }
}
