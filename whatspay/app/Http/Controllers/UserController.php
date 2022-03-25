<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try {
            $user = $this->userService->register($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        // return response
        return $this->sendResponse(['email' => $request['email']], __('user.success.activation_sent'));
    }

    public function login(Request $request)
    {
        try {
            $response = $this->userService->login($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($response, $response['message']);
    }

    public function verify(Request $request)
    {
        try {
            $token = $this->userService->verify($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($token, __('user.success.verified'));
    }

    public function verifyWithLink(Request $request)
    {
        try {
            $token = $this->userService->verifyWithLink($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($token, __('user.success.verified'));
    }

    public function resendActivationCode(Request $request)
    {
        try {
            $this->userService->resendActivationCode($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        // return response
        return $this->sendResponse([], __('user.success.activation_code_sent'));
    }

    public function resendActivation(Request $request)
    {
        try {
            $this->userService->resendActivation($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        // return response
        return $this->sendResponse([], __('user.success.activation_link_sent'));
    }

    public function forgot(Request $request)
    {
        try {
            $user = $this->userService->forgot($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        // return response
        return $this->sendResponse($user, __('user.success.activation_sent'));
    }

    public function reset(Request $request)
    {
        try {
            $this->userService->reset($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        // return response
        return $this->sendResponse([], __('user.success.password_changed'));
    }

    public function resetWithLink(Request $request)
    {
        try {
            $this->userService->resetWithLink($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], __('user.success.password_changed'));
    }

    public function changePassword(Request $request)
    {
        try {
            $this->userService->changePassword($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], __('user.success.password_changed'));
    }

    public function deactivate(Request $request)
    {
        try {
            $deactivated = $this->userService->deactivate();

            // delete all tokens
            if (true == $deactivated) {
                Auth::user()
                    ->tokens()
                    ->delete();
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], __('user.success.deactivated'));
    }

    public function destroy($email)
    {
        try {
            $this->userService->destroy($email);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'User deleted.');
    }

    public function profileUpdate(Request $request)
    {
        try {
            $user = $this->userService->ProfileUpdate($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($user, __('user.success.profile_updated'));
    }

    public function imageUpdate(Request $request)
    {
        try {
            $this->userService->imageUpdate($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.profile_image_updated'));
    }

    public function logout(Request $request)
    {
        try {
            $request
                ->user()
                ->currentAccessToken()
                ->delete();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.logout'));
    }

    public function default(Request $request, $store)
    {
        try {
            $this->userService->default($request, $store);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.default_store_updated'));
    }

    public function notificationview()
    {
        try {
            $data = $this->userService->notificationview();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($data, 'data found Created.');
    }
}
