<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();
            $table->string('contact_type');
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('contact_id')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('opening_balance')->default(0);
            $table->string('pay_term')->nullable();
            $table->string('pay_term_condition');
            $table->string('customer_group')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('avatar', 200)->nullable();
            $table->string('address', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('alternate_contact_no')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');

            $table->timestamps();
        });

        \Modules\Contact\Entities\ContactModel::create([
            'contact_type' => 'Customer',
            'name' => 'Walk In Customer',
            'note' => 'Default Account',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
}
