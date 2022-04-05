<?php

use Illuminate\Database\Migrations\Migration;

class AddApprovalFields extends Migration
{
    public function up(): void
    {
        App\Models\User::all()->each(function (App\Models\User $user): void {
            $user->update([
                'approved' => true,
            ]);
        });
    }
}
