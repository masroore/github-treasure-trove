<?php

use Illuminate\Database\Migrations\Migration;

class AddVerificationFields extends Migration
{
    public function up()
    {
        App\Models\User::all()->each(function (App\Models\User $user) {
            $user->update([
                'verified'    => true,
                'verified_at' => now(),
            ]);
        });
    }
}
