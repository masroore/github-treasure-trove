<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table): void {
            $table->integer('id');
            $table->integer('module_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('route')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->default(1)->unsigned();
            $table->integer('updated_by')->default(1)->unsigned();
            $table->integer('type')->nullable()->comment('1 for main menu, 2 for sub menu , 3 action');
            $table->timestamps();
        });

        $sql = [

            // Dashboard
            ['id' => 1, 'module_id' => 1, 'parent_id' => null, 'name' => 'Dashboard', 'route' => 'dashboard', 'type' => 1],

            ['id' => 400, 'module_id' => 22, 'parent_id' => null, 'name' => 'Project Management', 'route' => 'project', 'type' => 1],

            ['id' => 346, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Widgets', 'route' => 'widget', 'type' => 2],
            ['id' => 347, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Total Purchase', 'route' => 'widget.total_purchase', 'type' => 3],
            ['id' => 348, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Total Sale', 'route' => 'widget.total_sale', 'type' => 3],
            ['id' => 349, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Expense', 'route' => 'widget.expense', 'type' => 3],
            ['id' => 350, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Purchase Due', 'route' => 'widget.purchase_due', 'type' => 3],
            ['id' => 351, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Invoice Due', 'route' => 'widget.invoice_due', 'type' => 3],
            ['id' => 352, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Total in Bank', 'route' => 'widget.total_in_bank', 'type' => 3],
            ['id' => 353, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Total in Cash', 'route' => 'widget.total_in_cash', 'type' => 3],
            ['id' => 354, 'module_id' => 1, 'parent_id' => 346, 'name' => 'Net Profit', 'route' => 'widget.net_profit', 'type' => 3],

            ['id' => 355, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Sale Statistics', 'route' => 'sale_statistics', 'type' => 2],
            ['id' => 356, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Profit Statistics', 'route' => 'profit_statistics', 'type' => 2],
            ['id' => 357, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Recent Activity', 'route' => 'recent_activity', 'type' => 2],
            ['id' => 358, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Branch Wise Product Quantity', 'route' => 'showroom_wise_product_qty', 'type' => 2],
            ['id' => 359, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Payment Due List', 'route' => 'payment_due_list', 'type' => 2],
            ['id' => 360, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Stock Alert List', 'route' => 'stock_alert_list', 'type' => 2],
            ['id' => 361, 'module_id' => 1, 'parent_id' => 1, 'name' => 'To Do List', 'route' => 'to_do_list', 'type' => 2],
            // Product
            ['id' => 2, 'module_id' => 2, 'parent_id' => null, 'name' => 'Product', 'route' => '', 'type' => 1],

            ['id' => 3, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Variant', 'route' => 'variant.index', 'type' => 2],
            ['id' => 4, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variant Add', 'route' => 'variant.store', 'type' => 3],
            ['id' => 5, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variant Edit', 'route' => 'variant.edit', 'type' => 3],
            ['id' => 6, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variant Delete', 'route' => 'variant.delete', 'type' => 3],
            ['id' => 7, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variant Show', 'route' => 'variant.show', 'type' => 3],
            ['id' => 8, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variation list', 'route' => 'variation_list', 'type' => 3],
            ['id' => 9, 'module_id' => 2, 'parent_id' => 3, 'name' => 'Variant with values', 'route' => 'variant_with_values', 'type' => 3],

            ['id' => 10, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Unit Type', 'route' => 'unit_type.index', 'type' => 2],
            ['id' => 11, 'module_id' => 2, 'parent_id' => 10, 'name' => 'Unit Type Add', 'route' => 'unit_type.store', 'type' => 3],
            ['id' => 12, 'module_id' => 2, 'parent_id' => 10, 'name' => 'Unit Type Edit', 'route' => 'unit_type.edit', 'type' => 3],
            ['id' => 13, 'module_id' => 2, 'parent_id' => 10, 'name' => 'Unit Type Delete', 'route' => 'unit_type.delete', 'type' => 3],
            ['id' => 14, 'module_id' => 2, 'parent_id' => 10, 'name' => 'Unit Type Show', 'route' => 'unit_type.show', 'type' => 3],

            ['id' => 15, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Brand', 'route' => 'brand.index', 'type' => 2],
            ['id' => 16, 'module_id' => 2, 'parent_id' => 15, 'name' => 'Brand Add', 'route' => 'brand.store', 'type' => 3],
            ['id' => 17, 'module_id' => 2, 'parent_id' => 15, 'name' => 'Brand Edit', 'route' => 'brand.edit', 'type' => 3],
            ['id' => 18, 'module_id' => 2, 'parent_id' => 15, 'name' => 'Brand Delete', 'route' => 'brand.delete', 'type' => 3],
            ['id' => 19, 'module_id' => 2, 'parent_id' => 15, 'name' => 'Brand Show', 'route' => 'brand.show', 'type' => 3],

            ['id' => 20, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Model', 'route' => 'model.index', 'type' => 2],
            ['id' => 21, 'module_id' => 2, 'parent_id' => 20, 'name' => 'Add Model', 'route' => 'model.store', 'type' => 3],
            ['id' => 22, 'module_id' => 2, 'parent_id' => 20, 'name' => 'Edit', 'route' => 'model.edit', 'type' => 3],
            ['id' => 23, 'module_id' => 2, 'parent_id' => 20, 'name' => 'Delete', 'route' => 'model.delete', 'type' => 3],
            ['id' => 24, 'module_id' => 2, 'parent_id' => 20, 'name' => 'Show', 'route' => 'model.show', 'type' => 3],

            ['id' => 31, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Category', 'route' => 'category.index', 'type' => 2],
            ['id' => 32, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Add Category', 'route' => 'category.store', 'type' => 3],
            ['id' => 33, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Edit', 'route' => 'category.edit', 'type' => 3],
            ['id' => 34, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Delete', 'route' => 'category.delete', 'type' => 3],
            ['id' => 35, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Show', 'route' => 'category.show', 'type' => 3],
            ['id' => 36, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Category Parent', 'route' => 'category.parent', 'type' => 3],

            ['id' => 37, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Product', 'route' => 'add_product.index', 'type' => 2],
            ['id' => 38, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Add Product', 'route' => 'add_product.store', 'type' => 3],
            ['id' => 39, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Edit', 'route' => 'add_product.edit', 'type' => 3],
            ['id' => 40, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Delete', 'route' => 'add_product.delete', 'type' => 3],
            ['id' => 41, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Show', 'route' => 'add_product.show', 'type' => 3],
            ['id' => 42, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Category wise subcategory', 'route' => 'category_wise_subcategory', 'type' => 3],
            ['id' => 43, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Search', 'route' => 'add_product.search_index', 'type' => 3],
            ['id' => 44, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Destroy', 'route' => 'add_product.destroy', 'type' => 3],
            ['id' => 45, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Edit Combo', 'route' => 'add_product.editCombo', 'type' => 3],
            ['id' => 46, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Details', 'route' => 'add_product.product_Detail', 'type' => 3],
            ['id' => 47, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Combo Delete', 'route' => 'combo_product.destroy', 'type' => 3],
            ['id' => 48, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Update Active Status', 'route' => 'add_product.update_active_status', 'type' => 3],
            ['id' => 49, 'module_id' => 2, 'parent_id' => 37, 'name' => 'Product Sku', 'route' => 'product_sku.get_product_price', 'type' => 3],

            // Activity log

            ['id' => 61, 'module_id' => 3, 'parent_id' => null, 'name' => 'Activity Log', 'route' => 'activity_log', 'type' => 1],

            // Backup

            ['id' => 62, 'module_id' => 4, 'parent_id' => null, 'name' => 'Backup', 'route' => 'backup.index', 'type' => 1],
            ['id' => 63, 'module_id' => 4, 'parent_id' => 62, 'name' => 'Create', 'route' => 'backup.create', 'type' => 2],
            ['id' => 64, 'module_id' => 4, 'parent_id' => 62, 'name' => 'Delete', 'route' => 'backup.delete', 'type' => 2],

            // settings
            ['id' => 66, 'module_id' => 5, 'parent_id' => null, 'name' => 'Settings', 'route' => 'setting.index', 'type' => 1],
            ['id' => 67, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Update Activation Status', 'route' => 'update_activation_status', 'type' => 2],
            ['id' => 68, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Update Company Information', 'route' => 'company_information_update', 'type' => 2],
            ['id' => 69, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Sms gateway credentials update', 'route' => 'sms_gateway_credentials_update', 'type' => 2],
            ['id' => 70, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Email gateway credentials update', 'route' => 'smtp_gateway_credentials_update', 'type' => 2],
            ['id' => 71, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Test SMS', 'route' => 'sms_send_demo', 'type' => 2],
            ['id' => 72, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Test Mail', 'route' => 'test_mail.send', 'type' => 2],
            ['id' => 720, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Payment Method Settings', 'route' => 'payment-method-settings', 'type' => 2],
            ['id' => 721, 'module_id' => 5, 'parent_id' => 66, 'name' => 'System Update', 'route' => 'setting.updatesystem', 'type' => 2],
            ['id' => 722, 'module_id' => 5, 'parent_id' => 66, 'name' => 'General Setting', 'route' => 'general_settings.index', 'type' => 2],
            ['id' => 723, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Invoice Setting', 'route' => 'invoice_settings.index', 'type' => 2],
            ['id' => 724, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Email Template', 'route' => 'email_template.index', 'type' => 2],
            ['id' => 725, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Sms Template', 'route' => 'sms_template.index', 'type' => 2],

            // setup

            ['id' => 73, 'module_id' => 7, 'parent_id' => null, 'name' => 'SetUp', 'route' => 'setup', 'type' => 1],

            ['id' => 74, 'module_id' => 7, 'parent_id' => 73, 'name' => 'Country', 'route' => 'country.index', 'type' => 2],

            ['id' => 89, 'module_id' => 7, 'parent_id' => 73, 'name' => 'Tax', 'route' => 'tax.index', 'type' => 2],
            ['id' => 90, 'module_id' => 7, 'parent_id' => 89, 'name' => 'Add Tax', 'route' => 'tax.store', 'type' => 3],
            ['id' => 91, 'module_id' => 7, 'parent_id' => 89, 'name' => 'Edit', 'route' => 'tax.edit', 'type' => 3],
            ['id' => 92, 'module_id' => 7, 'parent_id' => 89, 'name' => 'Delete', 'route' => 'tax.destroy', 'type' => 3],
            ['id' => 93, 'module_id' => 7, 'parent_id' => 89, 'name' => 'Show', 'route' => 'tax.show', 'type' => 3],
            ['id' => 94, 'module_id' => 7, 'parent_id' => 89, 'name' => 'Change Status', 'route' => 'tax.update_active_status', 'type' => 3],

            ['id' => 95, 'module_id' => 7, 'parent_id' => 73, 'name' => 'Intro Prefix', 'route' => 'introPrefix.index', 'type' => 2],
            ['id' => 96, 'module_id' => 7, 'parent_id' => 95, 'name' => 'Add Intro Prefix', 'route' => 'introPrefix.store', 'type' => 3],
            ['id' => 97, 'module_id' => 7, 'parent_id' => 95, 'name' => 'Edit', 'route' => 'introPrefix.edit', 'type' => 3],
            ['id' => 98, 'module_id' => 7, 'parent_id' => 95, 'name' => 'Delete', 'route' => 'introPrefix.destroy', 'type' => 3],
            ['id' => 99, 'module_id' => 7, 'parent_id' => 95, 'name' => 'Show', 'route' => 'introPrefix.show', 'type' => 3],
            ['id' => 100, 'module_id' => 7, 'parent_id' => 95, 'name' => 'Search', 'route' => 'introPrefix.search_index', 'type' => 3],

            ['id' => 106, 'module_id' => 7, 'parent_id' => 73, 'name' => 'Currencies', 'route' => 'currencies.index', 'type' => 2],
            ['id' => 107, 'module_id' => 7, 'parent_id' => 106, 'name' => 'Add Currencies', 'route' => 'currencies.store', 'type' => 3],
            ['id' => 108, 'module_id' => 7, 'parent_id' => 106, 'name' => 'Edit', 'route' => 'currencies.edit', 'type' => 3],
            ['id' => 109, 'module_id' => 7, 'parent_id' => 106, 'name' => 'Delete', 'route' => 'currencies.delete', 'type' => 3],
            ['id' => 110, 'module_id' => 7, 'parent_id' => 106, 'name' => 'Show', 'route' => 'currencies.show', 'type' => 3],

            ['id' => 111, 'module_id' => 7, 'parent_id' => 73, 'name' => 'Language', 'route' => 'languages.index', 'type' => 2],
            ['id' => 112, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Add', 'route' => 'languages.store', 'type' => 3],
            ['id' => 113, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Edit', 'route' => 'languages.edit', 'type' => 3],
            ['id' => 114, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Delete', 'route' => 'languages.destroy', 'type' => 3],
            ['id' => 115, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Show', 'route' => 'language.translate_view', 'type' => 3],
            ['id' => 116, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Change Status', 'route' => 'languages.update_active_status', 'type' => 3],
            ['id' => 117, 'module_id' => 7, 'parent_id' => 111, 'name' => 'Change', 'route' => 'language.change', 'type' => 3],

            // Contact

            ['id' => 163, 'module_id' => 9, 'parent_id' => null, 'name' => 'Contact', 'route' => 'contact', 'type' => 1],

            ['id' => 164, 'module_id' => 9, 'parent_id' => 163, 'name' => 'Customer List', 'route' => 'customer', 'type' => 2],
            ['id' => 165, 'module_id' => 9, 'parent_id' => 163, 'name' => 'Supplier List', 'route' => 'supplier', 'type' => 2],

            ['id' => 166, 'module_id' => 9, 'parent_id' => 163, 'name' => 'Contact', 'route' => 'add_contact.index', 'type' => 2],
            ['id' => 167, 'module_id' => 9, 'parent_id' => 166, 'name' => 'Edit', 'route' => 'add_contact.edit', 'type' => 3],
            ['id' => 168, 'module_id' => 9, 'parent_id' => 166, 'name' => 'Delete', 'route' => 'add_contact.destroy', 'type' => 3],
            ['id' => 169, 'module_id' => 9, 'parent_id' => 166, 'name' => 'Add', 'route' => 'add_contact.store', 'type' => 3],
            ['id' => 169, 'module_id' => 9, 'parent_id' => 167, 'name' => 'Settings', 'route' => 'contact.settings', 'type' => 3],

            // Leave

            ['id' => 170, 'module_id' => 10, 'parent_id' => null, 'name' => 'Leave', 'route' => 'leave', 'type' => 1],

            ['id' => 171, 'module_id' => 10, 'parent_id' => 170, 'name' => 'Leave Define', 'route' => 'leave_define.index', 'type' => 2],
            ['id' => 172, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Add', 'route' => 'leave_define.store', 'type' => 3],
            ['id' => 173, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Edit', 'route' => 'leave_define.edit', 'type' => 3],
            ['id' => 174, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Delete', 'route' => 'leave_define.delete', 'type' => 3],
            ['id' => 175, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Approve', 'route' => 'approved_index', 'type' => 3],
            ['id' => 176, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Set Approval', 'route' => 'set_approval_leave', 'type' => 3],
            ['id' => 324, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Pending Leave', 'route' => 'pending_index', 'type' => 3],
            ['id' => 325, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Apply Leave', 'route' => 'apply_leave.index', 'type' => 3],
            ['id' => 326, 'module_id' => 10, 'parent_id' => 171, 'name' => 'Carry Forward', 'route' => 'carry.forward', 'type' => 3],

            // Human Resource
            ['id' => 177, 'module_id' => 11, 'parent_id' => null, 'name' => 'Human Resource', 'route' => 'human_resource', 'type' => 1],

            ['id' => 178, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Staffs', 'route' => 'staffs.index', 'type' => 2],
            ['id' => 179, 'module_id' => 11, 'parent_id' => 178, 'name' => 'Add Staffs', 'route' => 'staffs.store', 'type' => 3],
            ['id' => 180, 'module_id' => 11, 'parent_id' => 178, 'name' => 'Edit', 'route' => 'staffs.edit', 'type' => 3],
            ['id' => 181, 'module_id' => 11, 'parent_id' => 178, 'name' => 'Delete', 'route' => 'staffs.destroy', 'type' => 3],
            ['id' => 182, 'module_id' => 11, 'parent_id' => 178, 'name' => 'Update Status', 'route' => 'staffs.update_active_status', 'type' => 3],
            ['id' => 183, 'module_id' => 11, 'parent_id' => 178, 'name' => 'View', 'route' => 'staffs.view', 'type' => 3],

            ['id' => 184, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Department', 'route' => 'departments.index', 'type' => 2],
            ['id' => 185, 'module_id' => 11, 'parent_id' => 184, 'name' => 'Add Department', 'route' => 'departments.store', 'type' => 3],
            ['id' => 186, 'module_id' => 11, 'parent_id' => 184, 'name' => 'Edit', 'route' => 'departments.edit', 'type' => 3],
            ['id' => 187, 'module_id' => 11, 'parent_id' => 184, 'name' => 'Delete', 'route' => 'departments.delete', 'type' => 3],

            ['id' => 188, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Attendance Report', 'route' => 'attendance_report.index', 'type' => 2],

            ['id' => 189, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Attendance', 'route' => 'attendances.index', 'type' => 2],
            ['id' => 190, 'module_id' => 11, 'parent_id' => 189, 'name' => 'Add', 'route' => 'attendances.store', 'type' => 3],

            ['id' => 191, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Payroll', 'route' => 'payroll.index', 'type' => 2],
            ['id' => 192, 'module_id' => 11, 'parent_id' => 191, 'name' => 'Payroll Report', 'route' => 'payroll_reports.index', 'type' => 2],

            ['id' => 193, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Loan Approval', 'route' => 'apply_loans.loan_approval_index', 'type' => 2],
            ['id' => 194, 'module_id' => 11, 'parent_id' => 193, 'name' => 'Approve Loan', 'route' => 'set_approval_applied_loan', 'type' => 3],
            ['id' => 338, 'module_id' => 11, 'parent_id' => 193, 'name' => 'Loan Apply Index', 'route' => 'apply_loans.index', 'type' => 3],
            ['id' => 339, 'module_id' => 11, 'parent_id' => 193, 'name' => 'Loan History', 'route' => 'apply_loans.history', 'type' => 3],

            ['id' => 195, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Role', 'route' => 'permission.roles.index', 'type' => 2],
            ['id' => 196, 'module_id' => 11, 'parent_id' => 195, 'name' => 'Add', 'route' => 'permission.roles.store', 'type' => 3],
            ['id' => 197, 'module_id' => 11, 'parent_id' => 195, 'name' => 'Edit', 'route' => 'permission.roles.edit', 'type' => 3],
            ['id' => 198, 'module_id' => 11, 'parent_id' => 195, 'name' => 'Delete', 'route' => 'permission.roles.destroy', 'type' => 3],

            ['id' => 199, 'module_id' => 11, 'parent_id' => 177, 'name' => 'Permission', 'route' => 'permission.permissions.index', 'type' => 2],
            ['id' => 200, 'module_id' => 11, 'parent_id' => 199, 'name' => 'Add', 'route' => 'permission.permissions.create', 'type' => 3],
            ['id' => 201, 'module_id' => 11, 'parent_id' => 199, 'name' => 'Edit', 'route' => 'permission.permissions.edit', 'type' => 3],
            ['id' => 202, 'module_id' => 11, 'parent_id' => 199, 'name' => 'Delete', 'route' => 'permission.permissions.destroy', 'type' => 3],

            // Leave ---- Leave Type

            ['id' => 203, 'module_id' => 10, 'parent_id' => 170, 'name' => 'Leave Type', 'route' => 'leave_types.index', 'type' => 2],
            ['id' => 204, 'module_id' => 10, 'parent_id' => 203, 'name' => 'Add', 'route' => 'leave_types.store', 'type' => 3],
            ['id' => 205, 'module_id' => 10, 'parent_id' => 203, 'name' => 'Edit', 'route' => 'leave_types.edit', 'type' => 3],
            ['id' => 206, 'module_id' => 10, 'parent_id' => 203, 'name' => 'Delete', 'route' => 'leave_types.delete', 'type' => 3],

            // Purchase

            ['id' => 217, 'module_id' => 13, 'parent_id' => null, 'name' => 'Purchase', 'route' => 'purchase', 'type' => 1],

            ['id' => 218, 'module_id' => 13, 'parent_id' => 217, 'name' => 'Purchase Order', 'route' => 'purchase_order.index', 'type' => 2],
            ['id' => 219, 'module_id' => 13, 'parent_id' => 218, 'name' => 'Add Purchase Order', 'route' => 'purchase_order.store', 'type' => 3],
            ['id' => 220, 'module_id' => 13, 'parent_id' => 218, 'name' => 'Edit', 'route' => 'purchase_order.edit', 'type' => 3],
            ['id' => 221, 'module_id' => 13, 'parent_id' => 218, 'name' => 'Delete', 'route' => 'purchase.order.destroy', 'type' => 3],
            ['id' => 222, 'module_id' => 13, 'parent_id' => 218, 'name' => 'show', 'route' => 'purchase_order.show', 'type' => 3],

            ['id' => 223, 'module_id' => 13, 'parent_id' => 217, 'name' => 'Purchase Return', 'route' => 'purchase.return.index', 'type' => 2],
            ['id' => 224, 'module_id' => 13, 'parent_id' => 223, 'name' => 'Approve', 'route' => 'return.purchase.approve', 'type' => 3],

            // Sale

            ['id' => 225, 'module_id' => 13, 'parent_id' => null, 'name' => 'Sale', 'route' => 'sale', 'type' => 1],

            ['id' => 226, 'module_id' => 13, 'parent_id' => 225, 'name' => 'Sale', 'route' => 'sale.index', 'type' => 2],
            ['id' => 227, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Add Sale', 'route' => 'sale.store', 'type' => 3],
            ['id' => 228, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Edit', 'route' => 'sale.edit', 'type' => 3],
            ['id' => 229, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Delete', 'route' => 'sale.delete', 'type' => 3],
            ['id' => 230, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Show', 'route' => 'sale.show', 'type' => 3],
            ['id' => 342, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Sale Return', 'route' => 'sale.return', 'type' => 3],
            ['id' => 343, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Approval', 'route' => 'conditional.sale.approve', 'type' => 3],
            ['id' => 344, 'module_id' => 13, 'parent_id' => 226, 'name' => 'Return Approval', 'route' => 'return.sale.approve', 'type' => 3],

            ['id' => 231, 'module_id' => 13, 'parent_id' => 225, 'name' => 'Sale Return', 'route' => 'sale.return.index', 'type' => 2],

            // Inventory

            ['id' => 232, 'module_id' => 14, 'parent_id' => null, 'name' => 'Inventory', 'route' => 'inventory', 'type' => 1],

            ['id' => 318, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Openning Stock', 'route' => 'add_opening_stock_create', 'type' => 2],
            ['id' => 319, 'module_id' => 14, 'parent_id' => 318, 'name' => 'Openning Stock Add', 'route' => 'add_opening_stock_create', 'type' => 3],

            ['id' => 320, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Recieve Purchase Product', 'route' => 'purchase_order.recieve.index', 'type' => 2],
            ['id' => 321, 'module_id' => 14, 'parent_id' => 320, 'name' => 'Recieve Purchase Product', 'route' => 'purchase.add.stock', 'type' => 3],

            ['id' => 322, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Cost of Goods Sold', 'route' => 'purchase_order.cost_of_goods.index', 'type' => 2],
            ['id' => 323, 'module_id' => 14, 'parent_id' => 322, 'name' => 'History Index', 'route' => 'purchase_order.cost_of_goods.index', 'type' => 3],

            ['id' => 233, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Stock Transfar', 'route' => 'stock-transfer.index', 'type' => 2],
            ['id' => 234, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Add Stock Transfar', 'route' => 'stock-transfer.store', 'type' => 3],
            ['id' => 235, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Edit', 'route' => 'stock-transfer.edit', 'type' => 3],
            ['id' => 236, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Delete', 'route' => 'stock-transfer.delete', 'type' => 3],
            ['id' => 237, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Show', 'route' => 'stock-transfer.show', 'type' => 3],
            ['id' => 238, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Status Change', 'route' => 'stock-transfer.status', 'type' => 3],
            ['id' => 340, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Stock Sent Approval', 'route' => 'stock-transfer.sent', 'type' => 3],
            ['id' => 341, 'module_id' => 14, 'parent_id' => 233, 'name' => 'Transfered stock Recieve', 'route' => 'stock-transfer.receive', 'type' => 3],

            ['id' => 239, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Stock List', 'route' => 'stock.report', 'type' => 2],

            ['id' => 248, 'module_id' => 14, 'parent_id' => 232, 'name' => 'Stock adjustment', 'route' => 'stock_adjustment.index', 'type' => 2],
            ['id' => 249, 'module_id' => 14, 'parent_id' => 248, 'name' => 'Add Stock adjustment', 'route' => 'stock_adjustment.store', 'type' => 3],
            ['id' => 250, 'module_id' => 14, 'parent_id' => 248, 'name' => 'Edit', 'route' => 'stock_adjustment.edit', 'type' => 3],
            ['id' => 251, 'module_id' => 14, 'parent_id' => 248, 'name' => 'Delete', 'route' => 'stock_adjustment.destroy', 'type' => 3],
            ['id' => 252, 'module_id' => 14, 'parent_id' => 248, 'name' => 'Show', 'route' => 'stock_adjustment.show', 'type' => 3],
            ['id' => 253, 'module_id' => 14, 'parent_id' => 248, 'name' => 'Approve', 'route' => 'stock_adjustment.approve', 'type' => 3],

            // Quotation

            ['id' => 254, 'module_id' => 15, 'parent_id' => null, 'name' => 'Quotation', 'route' => 'quotation', 'type' => 1],
            ['id' => 255, 'module_id' => 15, 'parent_id' => 254, 'name' => 'Quotation', 'route' => 'quotation.index', 'type' => 2],
            ['id' => 256, 'module_id' => 15, 'parent_id' => 255, 'name' => 'Add Quotation', 'route' => 'quotation.store', 'type' => 3],
            ['id' => 257, 'module_id' => 15, 'parent_id' => 255, 'name' => 'Edit', 'route' => 'quotation.edit', 'type' => 3],
            ['id' => 258, 'module_id' => 15, 'parent_id' => 255, 'name' => 'Delete', 'route' => 'quotation.delete', 'type' => 3],
            ['id' => 289, 'module_id' => 15, 'parent_id' => 255, 'name' => 'Show', 'route' => 'quotation.show', 'type' => 3],

            // Accounts
            ['id' => 264, 'module_id' => 18, 'parent_id' => null, 'name' => 'Account', 'route' => 'accounts', 'type' => 1],

            ['id' => 289, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Expense', 'route' => 'expenses.index', 'type' => 2],
            ['id' => 290, 'module_id' => 18, 'parent_id' => 289, 'name' => 'Create Expense', 'route' => 'expenses.create', 'type' => 3],
            ['id' => 291, 'module_id' => 18, 'parent_id' => 289, 'name' => 'Add', 'route' => 'expenses.store', 'type' => 3],
            ['id' => 292, 'module_id' => 18, 'parent_id' => 289, 'name' => 'Edit', 'route' => 'expenses.edit', 'type' => 3],
            ['id' => 293, 'module_id' => 18, 'parent_id' => 289, 'name' => 'Delete', 'route' => 'expenses.delete', 'type' => 3],
            ['id' => 294, 'module_id' => 18, 'parent_id' => 289, 'name' => 'Show', 'route' => 'expenses.show', 'type' => 3],

            ['id' => 295, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Income', 'route' => 'income.index', 'type' => 2],
            ['id' => 296, 'module_id' => 18, 'parent_id' => 295, 'name' => 'Create Income', 'route' => 'income.create', 'type' => 3],
            ['id' => 297, 'module_id' => 18, 'parent_id' => 295, 'name' => 'Add', 'route' => 'income.store', 'type' => 3],
            ['id' => 298, 'module_id' => 18, 'parent_id' => 295, 'name' => 'Edit', 'route' => 'income.edit', 'type' => 3],
            ['id' => 299, 'module_id' => 18, 'parent_id' => 295, 'name' => 'Delete', 'route' => 'income.delete', 'type' => 3],
            ['id' => 300, 'module_id' => 18, 'parent_id' => 295, 'name' => 'Show', 'route' => 'income.show', 'type' => 3],

            ['id' => 301, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Bank Account', 'route' => 'bank_accounts.index', 'type' => 2],
            ['id' => 302, 'module_id' => 18, 'parent_id' => 301, 'name' => 'Create Bank', 'route' => 'bank_accounts.create', 'type' => 3],
            ['id' => 303, 'module_id' => 18, 'parent_id' => 301, 'name' => 'Add', 'route' => 'bank_accounts.store', 'type' => 3],
            ['id' => 304, 'module_id' => 18, 'parent_id' => 301, 'name' => 'Edit', 'route' => 'bank_accounts.edit', 'type' => 3],
            ['id' => 305, 'module_id' => 18, 'parent_id' => 301, 'name' => 'Delete', 'route' => 'bank_accounts.delete', 'type' => 3],
            ['id' => 306, 'module_id' => 18, 'parent_id' => 301, 'name' => 'Show', 'route' => 'bank_accounts.show', 'type' => 3],

            ['id' => 307, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Opening Balance', 'route' => 'openning_balance.index', 'type' => 2],
            ['id' => 308, 'module_id' => 18, 'parent_id' => 307, 'name' => 'Create Opening Balance', 'route' => 'openning_balance.create', 'type' => 3],
            ['id' => 309, 'module_id' => 18, 'parent_id' => 307, 'name' => 'Add', 'route' => 'openning_balance.store', 'type' => 3],
            ['id' => 310, 'module_id' => 18, 'parent_id' => 307, 'name' => 'Edit', 'route' => 'openning_balance.edit', 'type' => 3],
            ['id' => 311, 'module_id' => 18, 'parent_id' => 307, 'name' => 'Delete', 'route' => 'openning_balance.delete', 'type' => 3],
            ['id' => 312, 'module_id' => 18, 'parent_id' => 307, 'name' => 'Show', 'route' => 'openning_balance.show', 'type' => 3],

            ['id' => 283, 'module_id' => 18, 'parent_id' => 264, 'name' => 'char accounts', 'route' => 'char_accounts.index', 'type' => 2],
            ['id' => 284, 'module_id' => 18, 'parent_id' => 283, 'name' => 'Add', 'route' => 'char_accounts.store', 'type' => 3],
            ['id' => 285, 'module_id' => 18, 'parent_id' => 283, 'name' => 'Edit', 'route' => 'char_accounts.edit', 'type' => 3],
            ['id' => 286, 'module_id' => 18, 'parent_id' => 283, 'name' => 'Delete', 'route' => 'char_accounts.destroy', 'type' => 3],

            ['id' => 313, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Reports', 'route' => 'reports.index', 'type' => 2],
            ['id' => 314, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Transaction', 'route' => 'transaction.index', 'type' => 3],
            ['id' => 315, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Statement', 'route' => 'statement.index', 'type' => 3],
            ['id' => 316, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Profit', 'route' => 'profit.index', 'type' => 3],
            ['id' => 317, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Account Balance', 'route' => 'account.balance.index', 'type' => 3],
            ['id' => 318, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Income by customer', 'route' => 'income_by_customer', 'type' => 3],
            ['id' => 319, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Expense by customer', 'route' => 'expense_by_supplier', 'type' => 3],
            ['id' => 320, 'module_id' => 18, 'parent_id' => 313, 'name' => 'Sale tax', 'route' => 'sale_tax', 'type' => 3],

            ['id' => 315, 'module_id' => 18, 'parent_id' => 264, 'name' => 'Transfer Money ', 'route' => 'transfer_showroom.index', 'type' => 2],
            ['id' => 316, 'module_id' => 18, 'parent_id' => 315, 'name' => 'Make Mone Transfer', 'route' => 'transfer_showroom.create', 'type' => 3],
            ['id' => 317, 'module_id' => 18, 'parent_id' => 315, 'name' => 'Make Mone Transfer Update', 'route' => 'transfer_showroom.edit', 'type' => 3],

            ['id' => 338, 'module_id' => 20, 'parent_id' => null, 'name' => 'Location', 'route' => null, 'type' => 1],
            ['id' => 240, 'module_id' => 20, 'parent_id' => 338, 'name' => 'Warehouse', 'route' => 'warehouse.index', 'type' => 2],
            ['id' => 241, 'module_id' => 20, 'parent_id' => 240, 'name' => 'Add', 'route' => 'warehouse.store', 'type' => 3],
            ['id' => 242, 'module_id' => 20, 'parent_id' => 240, 'name' => 'Edit', 'route' => 'warehouse.edit', 'type' => 3],
            ['id' => 243, 'module_id' => 20, 'parent_id' => 240, 'name' => 'Delete', 'route' => 'warehouse.destroy', 'type' => 3],

            ['id' => 244, 'module_id' => 20, 'parent_id' => 338, 'name' => 'Branch', 'route' => 'showroom.index', 'type' => 2],
            ['id' => 245, 'module_id' => 20, 'parent_id' => 244, 'name' => 'Add', 'route' => 'showroom.store', 'type' => 3],
            ['id' => 246, 'module_id' => 20, 'parent_id' => 244, 'name' => 'Edit', 'route' => 'showroom.edit', 'type' => 3],
            ['id' => 247, 'module_id' => 20, 'parent_id' => 244, 'name' => 'Delete', 'route' => 'showroom.destroy', 'type' => 3],

            ['id' => 800, 'module_id' => 20, 'parent_id' => null, 'name' => 'Cashbook', 'route' => 'cashbook.index', 'type' => 1],

        ];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
}
