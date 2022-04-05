<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChartAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chart_accounts', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->boolean('is_group')->default(false);
            $table->string('name', 150);
            $table->string('type', 150);
            $table->tinyInteger('configuration_group_id')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('status')->default(0);
            $table->string('contactable_type', 255)->nullable();
            $table->unsignedBigInteger('contactable_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `chart_accounts` (`id`, `code`, `level`, `is_group`, `name`, `type`, `configuration_group_id`, `description`, `parent_id`, `status`, `contactable_type`, `contactable_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
        (1, '01-01', 1, 1, 'Group Cash Account', '1', NULL, 'Cash Account', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:34:57', '2020-11-10 23:34:57'),
        (2, '01-01-02', 2, 0, 'Cash account', '1', 1, NULL, 1, 1, NULL, NULL, 2, 2, '2020-11-10 23:35:58', '2020-11-10 23:35:58'),
        (3, '01-03', 1, 1, 'Bank & Mobile Banking Account', '1', NULL, 'Bank & Mobile Banking Account', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:36:42', '2020-11-10 23:36:42'),
        (4, '01-03-04', 2, 0, 'Bank Account', '1', 2, 'Bank Account', 3, 1, NULL, NULL, 2, 2, '2020-11-10 23:37:06', '2020-11-10 23:37:06'),
        (5, '01-05', 1, 1, 'Account Receivable (Group Account of Customer & Retailer)', '1', NULL, 'Account Receivable (Group Account of Customer & Retailer)', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:38:15', '2020-11-10 23:38:15'),
        (6, '01-06', 1, 1, 'Advance & Loan', '1', NULL, 'Advance & Loan', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:54:28', '2020-11-10 23:54:28'),
        (7, '01-07', 1, 0, 'Purchase & Inventory Account', '1', NULL, 'Purchase & Inventory Account', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:55:08', '2020-11-10 23:55:08'),
        (8, '02-08', 1, 1, 'Account Payable (Group Account)', '2', NULL, 'Account Payable (Group Account)', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:56:47', '2020-11-10 23:56:47'),
        (9, '02-09', 1, 1, 'Capital & Equity', '2', NULL, 'Capital & Equity', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:57:12', '2020-11-10 23:57:12'),
        (10, '02-09-10', 2, 0, 'Capital Account', '2', NULL, 'Capital Account', 9, 1, NULL, NULL, 2, 2, '2020-11-10 23:58:26', '2020-11-10 23:58:26'),
        (11, '02-09-11', 2, 0, 'Capital (Opening Balance Purpose)', '2', NULL, 'Capital (Opening Balance Purpose)', 9, 1, NULL, NULL, 2, 2, '2020-11-10 23:59:02', '2020-11-10 23:59:02'),
        (12, '02-12', 1, 1, 'Tax Account (Group Account)', '2', NULL, 'Tax Account (Group Account)', NULL, 1, NULL, NULL, 2, 2, '2020-11-10 23:59:38', '2020-11-10 23:59:38'),
        (13, '02-12-13', 2, 0, 'Product Tax', '2', NULL, 'Product Tax', 12, 1, NULL, NULL, 2, 2, '2020-11-11 00:00:18', '2020-11-11 00:00:18'),
        (14, '02-14', 1, 0, 'Retailer Earning (Profit)', '2', NULL, 'Retailer Earning (Profit)', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:00:51', '2020-11-11 00:00:51'),
        (15, '04-15', 1, 0, 'Sales', '4', NULL, 'Sales', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:01:37', '2020-11-11 00:01:37'),
        (16, '04-16', 1, 1, 'Other Income (Group Account)', '4', NULL, 'Other Income (Group Account)', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:02:05', '2020-11-11 00:02:05'),
        (17, '04-16-17', 2, 0, 'Salary Deduction Account', '4', NULL, 'Salary Deduction Account', 16, 1, NULL, NULL, 2, 2, '2020-11-11 00:02:28', '2020-11-11 00:02:28'),
        (18, '03-18', 1, 0, 'Salary & Allowance List', '3', NULL, 'Salary & Allowance List', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:03:20', '2020-11-11 00:03:20'),
        (19, '03-19', 1, 0, 'Cost Of Goods Sold', '3', NULL, 'Cost Of Goods Sold', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:03:38', '2020-11-11 00:03:38'),
        (20, '03-20', 1, 0, 'Retailer Sales Commission', '3', NULL, 'Retailer Sales Commission', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:04:24', '2020-11-11 00:04:24'),
        (21, '03-21', 1, 0, 'Discount Expense', '3', NULL, 'Discount Expense', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:04:48', '2020-11-11 00:04:48'),
        (22, '03-22', 1, 0, 'Extra Salary Allowance', '3', NULL, 'Extra Salary Allowance', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:05:10', '2020-11-11 00:05:10'),
        (23, '03-23', 1, 0, 'Sales Return Account', '3', NULL, 'Sales Return Account', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:41:56', '2020-11-11 00:41:56'),
        (24, '04-24', 1, 0, 'Purchase Return Account', '4', NULL, 'Purchase Return Account', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:55:13', '2020-11-11 00:55:13'),
        (25, '03-25', 1, 0, 'Packaging Cost', '3', NULL, 'Packaging Cost', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:55:13', '2020-11-11 00:55:13'),
        (26, '01-26', 1, 0, 'Purchase Tax', '1', NULL, 'Purchase Tax', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:55:13', '2020-11-11 00:55:13'),
        (27, '01-27', 1, 0, 'Purchase Other Tax', '1', NULL, 'Purchase Other Tax', NULL, 1, NULL, NULL, 2, 2, '2020-11-11 00:55:13', '2020-11-11 00:55:13'),
        (28, '04-16-28', 2, 0, 'Purchase Discount(Income)', '4', NULL, 'Purchase Discount(Income)', 16, 1, NULL, NULL, 2, 2, '2020-11-11 00:55:13', '2020-11-11 00:55:13')");

        $sql = [
            ['code' => '02-05-29',
                'level' => '2',
                'is_group' => '0',
                'name' => 'Walk in Customer',
                'type' => '1',
                'configuration_group_id' => null,
                'description' => 'Walk in Customer',
                'parent_id' => 5,
                'status' => '1',
                'contactable_type' => 'Modules\\Contact\\Entities\\ContactModel',
                'contactable_id' => '1',
            ],

            ['code' => '03-30',
                'level' => '2',
                'is_group' => '0',
                'name' => 'Stripe',
                'type' => '1',
                'configuration_group_id' => '2',
                'description' => 'Stripe Payment',
                'parent_id' => '3',
                'status' => '1',
                'contactable_type' => '',
                'contactable_id' => '',
            ],

            ['code' => '03-31',
                'level' => '2',
                'is_group' => '0',
                'name' => 'Paypal',
                'type' => '1',
                'configuration_group_id' => '2',
                'description' => 'Paypal Payment',
                'parent_id' => '3',
                'status' => '1',
                'contactable_type' => '',
                'contactable_id' => '',
            ],

            ['code' => '04-16-32',
                'level' => '2',
                'is_group' => '0',
                'name' => 'Others Income',
                'type' => '4',
                'configuration_group_id' => '2',
                'description' => 'Others Income',
                'parent_id' => 16,
                'status' => '1',
                'contactable_type' => '',
                'contactable_id' => '',
            ],

            ['code' => '03-33',
                'level' => '1',
                'is_group' => '0',
                'name' => 'Others Expense',
                'type' => '3',
                'configuration_group_id' => '2',
                'description' => 'Others Expense',
                'parent_id' => null,
                'status' => '1',
                'contactable_type' => '',
                'contactable_id' => '',
            ],
        ];
        DB::table('chart_accounts')->insert($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_accounts');
    }
}
