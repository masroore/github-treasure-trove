<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidToAllTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_options', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('admin_users', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('advertisements', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('banners', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('countries', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('coupons', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('customers', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('customer_users', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('faqs', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('order_products', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('pages', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('page_components', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('product_questions', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('product_question_answers', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });

        Schema::table('shipping_couriers', function (Blueprint $table): void {
            $table->string('uuid')
                ->default(null)
                ->unique()
                ->nullable()
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_options', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('admin_users', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('advertisements', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('banners', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('countries', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('coupons', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('customers', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('customer_users', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('faqs', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('order_products', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('pages', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('page_components', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('product_questions', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('product_question_answers', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });

        Schema::table('shipping_couriers', function (Blueprint $table): void {
            $table->dropColumn('uuid');
        });
    }
}
