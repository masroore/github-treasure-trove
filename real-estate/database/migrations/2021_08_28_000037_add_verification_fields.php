<?php

use Illuminate\Database\Migrations\Migration;

class AddVerificationFields extends Migration
{
    public function up(): void
    {
        App\Models\User::all()->each(function (App\Models\User $user): void {
            $user->update([
                'verified' => true,
                'verified_at' => now(),
            ]);
        });
    }
}
