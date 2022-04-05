<?php

use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up(): void
    {
        Schema::create($this->table(), function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->morphs('holder');
            $table->string('name');
            $table->string('slug')->index();
            $table->string('description')->nullable();
            $table->decimal('balance', 64, 0)->default(0);
            $table->timestamps();

            $table->unique(['holder_type', 'holder_id', 'slug']);
        });

        /**
         * migrate v1 to v2.
         */
        $default = config('wallet.wallet.default.name', 'Default Wallet');
        $slug = config('wallet.wallet.default.slug', 'default');
        $now = time();
        $query = Transaction::query()->distinct()
            ->selectRaw('payable_type as holder_type')
            ->selectRaw('payable_id as holder_id')
            ->selectRaw('? as name', [$default])
            ->selectRaw('? as slug', [$slug])
            ->selectRaw('sum(amount) as balance')
            ->selectRaw('? as created_at', [$now])
            ->selectRaw('? as updated_at', [$now])
            ->groupBy('holder_type', 'holder_id')
            ->orderBy('holder_type');

        DB::transaction(function () use ($query): void {
            $query->chunk(1000, function (Collection $transactions): void {
                DB::table((new Wallet())->getTable())
                    ->insert($transactions->toArray());
            });
        });
    }

    public function down(): void
    {
        Schema::drop($this->table());
    }

    protected function table(): string
    {
        return (new Wallet())->getTable();
    }
}
