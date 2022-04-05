<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMomProfileRequest;
use App\Models\Cart;
use App\Models\City;
use App\Models\HospitalProduct;
use App\Models\User;
use App\Traits\LogTrait;
use App\Traits\MomProfileTrait;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Storage;
use Validator;

class MomProfileController extends Controller
{
    use LogTrait;
    use MomProfileTrait;

    public function __construct()
    {
    }

    public function getMomProfile($id, Request $request)
    {
        $user = User::find($id);
        if (empty($user)) {
            abort(404, 'Usuario no encontrado');
        }

        $maternityPackage = null;
        $receiptUrl = null;

        //GET THE LAST MATERNITY PACKAGE WITH BALANCE
        if ($user->step == 'maternity_package') {
            $cart = $user->cart()->where('balance', '>', 0)
                ->orderBy('id', 'desc')
                ->first();

            $basePrice = $cart->items[0]->total;
            $deposit = $cart->items[0]->hospitalProduct->deposit;
            $realPrice = ($basePrice * $deposit) / 100;
            $maternityPackage = [
                'id' => $cart->id,
                'city' => $cart->items[0]->hospitalProduct->hospital->city_id,
                'hospital' => $cart->items[0]->hospitalProduct->hospital_id,
                'product' => $cart->items[0]->hospitalProduct->id,
                'subtotal' => $realPrice,
                'iva' => round($realPrice * 0.16, 2),
                'total' => round($realPrice * 1.16, 2),
                'description' => 'Contratación de paquete medico de maternidad: ' . $cart->items[0]->hospitalProduct->product->product . '.',
            ];
        }

        if ($user->step == 'parcial_payment') {
            $cart = $user->cart()->where('balance', '>', 0)
                ->orderBy('id', 'desc')
                ->first();

            $receiptUrl = asset('storage/moms/' . $user->id . '/' . $cart->payments()->first()->receipt);
        }

        return view('mom_panel.mom-profile')
            ->with([
                'user' => $user,
                'cities' => City::where('status', 1)->get(),
                'maternityPackage' => $maternityPackage,
                'receiptUrl' => $receiptUrl,
            ]);
    }

    public function changePhoto(Request $request, $user_id)
    {
        $mom = User::find($user_id);
        $filename = time() . '.' . $request->file('photo')->getClientOriginalExtension();

        if (empty($mom)) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:jpeg,bmp,png,gif,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray(),

            ], 422);
        }

        try {
            if ($mom->photo != null) {
                Storage::delete('public/moms/' . $mom->id . '/' . $mom->photo);
            }

            Storage::put('public/moms/' . $mom->id . '/' . $filename, file_get_contents($request->file('photo')));
            $mom->update([
                'photo' => $filename,
            ]);

            return response()->json(['message' => 'Foto de perfil actualizada correctamente'], 200);
        } catch (QueryException $e) {
            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'database');

            return response()->json(['message' => 'Hubo un error al adjuntar tu visa, comunícate con uno de nuestros agentes'], 500);
        }
    }

    public function postUpdateProfile($id, UpdateMomProfileRequest $request)
    {
        $user = User::find($id);

        if (empty($user)) {
            $request->session()->flash('error', 'Usuario no encontrado');

            return back();
        }

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request['name'],
                'step' => $user->step == 'lead' ? 'profile' : $user->step,
            ]);

            $profileData = [
                'phone' => $request['phone'],
                'birth_date' => $request['birth_date'],
                'job' => $request['job'],
                'pregnancy_week' => $request['pregnancy_week'],
                'how_found' => $request['how_found'],
                'about_me' => $request['about_me'],
            ];

            if ($user->momProfile == null) {
                $user->momProfile()->create($profileData);
            }

            $user->momProfile()->update($profileData);

            DB::commit();

            $request->session()->flash('success', 'Tu perfil ha sido actualizado correctamente');

            return back()
                ->withInput();
        } catch (QueryException $e) {
            DB::rollBack();

            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'database');

            $request->session()->flash('error', 'Hubo un error al actualizar tu perfil, intenta más tarde');

            return back()
                ->withInput();
        }
    }

    public function setMaternityPackage($hospitalProductId, Request $request)
    {
        $hospitalProduct = HospitalProduct::find($hospitalProductId);
        if (empty($hospitalProduct)) {
            abort(404, 'No se encontró el paquete seleccionado');
        }

        try {
            DB::beginTransaction();

            $isACartCreated = Cart::where('user_id', Auth::user()->id)
                ->where('balance', $hospitalProduct->price)
                ->get()
                ->last();

            if (!empty($sessionCart = $isACartCreated)) {
                //OVERWRITES THE SELECTED PACKAGE ON THE PREVIOUS CART
                $isACartCreated->items[0]->update([
                    'hospital_product_id' => $hospitalProduct->id,
                    'total' => $hospitalProduct->price,
                ]);

                Auth::user()->hospitalSchedule()->delete();
            } else {
                $sessionCart = $cart = Auth::user()->cart()->create([
                    'amount' => $hospitalProduct->price,
                    'balance' => $hospitalProduct->price,
                ]);

                $cart->items()->create([
                    'hospital_product_id' => $hospitalProduct->id,
                    'quantity' => 1,
                    'total' => $hospitalProduct->price,
                ]);
            }

            Auth::user()->update([
                'step' => Auth::user()->step == 'profile' ? 'maternity_package' : Auth::user()->step,
            ]);

            DB::commit();

            $request->session()->flash('success', 'Has elegido tu paquete correctamente');

            return response()->redirectTo(route('web.getMomProfile', [Auth::user()->id]));
        } catch (QueryException $e) {
            DB::rollBack();

            $this->saveLog($e->getMessage(), $e->getCode(), 'database');

            $request->session()->flash('error', 'Hubo un error al seleccionar el paquete, intente nuevamente');

            return back();
        }
    }
}
