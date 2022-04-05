<?php

namespace Modules\AdminApi\Http\Controllers\v1\customer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminApi\Services\CustomerCheckoutService;
use Modules\AdminApi\Services\GuestCheckoutService;

class CheckoutController extends Controller
{
    private $errors = [];

    public function guestCheckout(Request $request, GuestCheckoutService $service)
    {
        if (!$this->validateParams($request)) {
            return response([
                'status' => false,
                'errors' => $this->errors,
                'msg' => 'please Check Your Details !',

            ], 200);
        }

        return $service->handle($request);
    }

    public function customerCheckout(Request $request, CustomerCheckoutService $service)
    {
        if (!$this->validateParams($request)) {
            return response([
                'status' => false,
                'errors' => $this->errors,
                'msg' => 'please Check Your Details !',

            ], 200);
        }

        return $service->handle($request);
    }

    private function validateParams($data)
    {
        $check = true;
        if (!isset($data->stripeToken)) {
            $this->errors['stripeToken'] = 'stripe token not found.';
            $check = false;
        }
        if (!isset($data->first_name)) {
            $this->errors['first_name'] = 'please enter your first name.';
            $check = false;
        }

        if (!isset($data->last_name)) {
            $this->errors['last_name'] = 'please enter your last name.';
            $check = false;
        }

        if (!isset($data->email)) {
            $this->errors['email'] = 'please enter your email.';
            $check = false;
        }

        if (isset($data->email) && !filter_var($data->email, \FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'please enter valid email.';
            $check = false;
        }

        if (!isset($data->phone)) {
            $this->errors['phone'] = 'please enter your phone number';
            $check = false;
        }
        if (!isset($data->country)) {
            $this->errors['country'] = 'please select your country';
            $check = false;
        }
        if (!isset($data->state)) {
            $this->errors['state'] = 'please select your state';
            $check = false;
        }
        if (!isset($data->city)) {
            $this->errors['city'] = 'please enter you city';
            $check = false;
        }

        if (!isset($data->postcode)) {
            $this->errors['postcode'] = 'please enter your postcode';
            $check = false;
        }
        // if (isset($data->postcode) && !is_numeric($data->postcode)) {
        //     $this->errors['postcode'] = 'post code should contain only numbers.';
        //     $check = false;

        // }
        if (!isset($data->address_1)) {
            $this->errors['address_1'] = 'please enter your address 1';
            $check = false;
        }
        if (!isset($data->shipping_first_name)) {
            $this->errors['shipping_first_name'] = 'please enter shipping first name';
            $check = false;
        }
        if (!isset($data->shipping_last_name)) {
            $this->errors['shipping_last_name'] = 'please enter shipping last name';
            $check = false;
        }

        if (!isset($data->shipping_email)) {
            $this->errors['shipping_email'] = 'please enter your shipping email.';
            $check = false;
        }

        if (isset($data->shipping_email) && !filter_var($data->shipping_email, \FILTER_VALIDATE_EMAIL)) {
            $this->errors['shipping_email'] = 'please enter valid shipping email.';
            $check = false;
        }

        if (!isset($data->shipping_phone)) {
            $this->errors['shipping_phone'] = 'please enter your shipping phone';
            $check = false;
        }

        if (!isset($data->shipping_country)) {
            $this->errors['shipping_country'] = 'please select your shipping country';
            $check = false;
        }
        if (!isset($data->shipping_state)) {
            $this->errors['shipping_state'] = 'please select your shipping state';
            $check = false;
        }
        if (!isset($data->shipping_city)) {
            $this->errors['shipping_city'] = 'please enter you shipping city';
            $check = false;
        }

        if (!isset($data->shipping_postcode)) {
            $this->errors['shipping_postcode'] = 'please enter your shipping postcode';
            $check = false;
        }

        if (isset($data->shipping_postcode) && !is_numeric($data->shipping_postcode)) {
            $this->errors['shipping_postcode'] = 'post code should contain only numbers.';
            $check = false;
        }

        if (!isset($data->shipping_address_1)) {
            $this->errors['shipping_address_1'] = 'please enter your shipping_address 1';
            $check = false;
        }

        return $check;
    }
}
