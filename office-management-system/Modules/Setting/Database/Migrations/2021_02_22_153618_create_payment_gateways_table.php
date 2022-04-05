<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table): void {
            $table->id();
            $table->string('gateway_name')->nullable();
            $table->string('gateway_username')->nullable();
            $table->string('gateway_password')->nullable();
            $table->string('gateway_signature')->nullable();
            $table->string('gateway_client_id')->nullable();
            $table->string('gateway_mode')->nullable();
            $table->string('gateway_api_key')->nullable();
            $table->string('gateway_secret_key')->nullable();
            $table->string('gateway_publisher_key')->nullable();
            $table->string('gateway_private_key')->nullable();
            $table->string('redirect_url')->nullable();
            $table->tinyInteger('active_status')->default(1);

            $table->text('bank_details')->nullable();
            $table->text('cheque_details')->nullable();

            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->timestamps();
        });

        DB::table('payment_gateways')->insert([

            [
                'gateway_name' => 'Stripe',
                'gateway_username' => 'demo@strip.com',
                'gateway_password' => '12334589',
                'gateway_client_id' => '',
                'gateway_api_key' => 'pk_test_51HCgdXH0fV5JGUSf9sz1ksFaT4FfpTz1xuHmpaV6MmXvbBg7H10H5VgvvfzMiGtUF3EJP4PpinVFXJWZtuDO0QQn005EkhlFtC',
                'gateway_secret_key' => 'sk_test_51HCgdXH0fV5JGUSfiNBoJUpDC9hYFff56A31nRD4fOVLqg0Fl2jm4b9xX70XQbEsEvFGRzEPIHkfINKecazqPOhF003WSV0dHc',
                'created_at' => date('Y-m-d h:i:s'),
                'redirect_url' => 'http://uxseven.com/infixbio',
            ],
            [
                'gateway_name' => 'Paypal',
                'gateway_username' => 'demo@paypal.com',
                'gateway_password' => '12334589',
                'gateway_client_id' => '',
                'gateway_api_key' => 'Ab7PORaM7Qu7mQlumVUZn3-HlSFHJks1pcnxnrCALoMiRs0NyrHg02JwbHMf2tsfV_jy1ziLzv5CdB3G',
                'gateway_secret_key' => 'EKtbarnhCk46f0fSrYPrzs89I3dd9ZeUCyGIguy0mfuLcrrwOp0KHcRtKvCi3T0OR2r35plQv76h5L7p',
                'created_at' => date('Y-m-d h:i:s'),
                'redirect_url' => 'http://uxseven.com/infixbio',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
}
