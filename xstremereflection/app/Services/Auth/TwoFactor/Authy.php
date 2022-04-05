<?php

namespace Vanguard\Services\Auth\TwoFactor;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Vanguard\Services\Auth\TwoFactor\Contracts\Authenticatable as TwoFactorAuthenticatable;
use Vanguard\Services\Auth\TwoFactor\Contracts\Provider;

class Authy implements Provider
{
    /**
     * Determine if the given user has two-factor authentication enabled.
     *
     * @return bool
     */
    public function isEnabled(TwoFactorAuthenticatable $user)
    {
        $options = $user->getTwoFactorAuthProviderOptions();

        return isset($options['enabled']) && $options['enabled'] === true;
    }

    /**
     * Register the given user with the provider.
     */
    public function register(TwoFactorAuthenticatable $user): void
    {
        $key = config('services.authy.key');

        $response = json_decode((new HttpClient())->post('https://api.authy.com/protected/json/users/new?api_key=' . $key, [
            'form_params' => [
                'user' => [
                    'email' => $user->getEmailForTwoFactorAuth(),
                    'cellphone' => preg_replace('/[^0-9]/', '', $user->getAuthPhoneNumber()),
                    'country_code' => $user->getAuthCountryCode(),
                ],
            ],
        ])->getBody(), true);

        $user->setTwoFactorAuthProviderOptions([
            'id' => $response['user']['id'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function sendTwoFactorVerificationToken(TwoFactorAuthenticatable $user)
    {
        $key = config('services.authy.key');

        $options = $user->getTwoFactorAuthProviderOptions();

        $response = json_decode((new HttpClient())->get(
            'https://api.authy.com/protected/json/sms/' . $options['id'] . '?force=true&api_key=' . $key
        )->getBody(), true);

        return $response['success'] === true;
    }

    /**
     * Determine if the given token is valid for the given user.
     *
     * @param  string $token
     *
     * @return bool
     */
    public function tokenIsValid(TwoFactorAuthenticatable $user, $token)
    {
        try {
            $key = config('services.authy.key');

            $options = $user->getTwoFactorAuthProviderOptions();

            $response = json_decode((new HttpClient())->get(
                'https://api.authy.com/protected/json/verify/' . $token . '/' . $options['id'] . '?force=true&api_key=' . $key
            )->getBody(), true);

            return $response['token'] === 'is valid';
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete the given user from the provider.
     *
     * @return bool
     */
    public function delete(TwoFactorAuthenticatable $user)
    {
        $key = config('services.authy.key');

        $options = $user->getTwoFactorAuthProviderOptions();

        (new HttpClient())->post(
            'https://api.authy.com/protected/json/users/delete/' . $options['id'] . '?api_key=' . $key
        );

        $user->setTwoFactorAuthProviderOptions([]);
    }
}
