<?php

use Bavix\Wallet\Models\Transfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStatusTransfersTable extends Migration
{
    public function up(): void
    {
        Schema::table($this->table(), function (Blueprint $table): void {
            $enums = [
                Transfer::STATUS_PAID,
                Transfer::STATUS_REFUND,
                Transfer::STATUS_GIFT,
            ];

            $table->enum('status', $enums)
                ->default(Transfer::STATUS_PAID)
                ->after('to_id');

            $table->enum('status_last', $enums)
                ->nullable()
                ->after('status');
        });

        DB::table($this->table())
            ->where('refund', true)
            ->update([
                'status' => Transfer::STATUS_REFUND,
                'status_last' => Transfer::STATUS_PAID,
            ]);
    }

    public function down(): void
    {
        DB::table($this->table())
            ->where('status', Transfer::STATUS_REFUND)
            ->update(['refund' => true]);

        Schema::table($this->table(), function (Blueprint $table): void {
            $table->dropColumn(['status', 'status_last']);
        });
    }

    protected function table(): string
    {
        return (new Transfer())->getTable();
    }
}
