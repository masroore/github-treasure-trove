<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();
        Fortify::authenticateUsing(function (LoginRequest $request) {
            $user = User::where('email', $request->email)->first();

            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                if ($user->email == 'elms@sksu.edu.ph') {
                    return $user;
                }
                if (!$user->roles()->first()) {
                    abort(404);
                }
                switch ($user->roles()->first()->id) {
                    case 2:
                        session(['whereami' => 'student']);

                        break;
                    case 3:
                        session(['whereami' => 'teacher']);

                        break;
                    case 4:
                        session(['whereami' => 'programhead']);

                        break;
                    case 5:
                        session(['whereami' => 'dean']);

                        break;
                }

                return $user;
            }
        });
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
