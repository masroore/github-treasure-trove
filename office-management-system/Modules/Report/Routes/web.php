<?php

use Illuminate\Support\Facades\Route;

Route::prefix('report')->group(function (): void {
    Route::prefix('sales-report')->group(function (): void {
        Route::middleware('permission')->group(function (): void {
            Route::get('/index', 'SalesReportController@index')->name('sales_report.index');
            Route::get('/product-sales', 'SalesReportController@product_sales_index')->name('product_sales_report.index');
            Route::get('/return-report', 'SalesReportController@sales_return_report')->name('sales_return_report.index');
        });
        Route::get('/search', 'SalesReportController@index')->name('sales_report.search_index');
    });

    Route::prefix('purchase-report')->group(function (): void {
        Route::middleware('permission')->group(function (): void {
            Route::get('/index', 'PurchaseReportController@index')->name('purchase_report.index');
            Route::get('/product-purchase', 'PurchaseReportController@product_purchase_index')->name('product_purchase_report.index');
            Route::get('/return-report', 'PurchaseReportController@purchase_return_report')->name('purchase_return_report.index');
        });
    });
    Route::prefix('ledger-report')->group(function (): void {
        Route::get('/index', 'LedgerReportController@index')->name('leadger_report.index')->middleware('permission');
        Route::get('/print-view-ledger/{slug}', 'LedgerReportController@print_view')->name('leadger_report.print_view')->middleware('permission');
    });

    Route::get('opening-balance-report/index', 'ReportController@index')->name('opening_balance_report.index');

    Route::get('income-statement', 'IncomeStateMentController@index')->name('income_statement_report.index');
    Route::get('income-expense-statement/daily', 'IncomeStateMentController@dailyReport')->name('income_statement_report.daily');
    Route::get('income-expense-statement/daily-search', 'IncomeStateMentController@dailyReportSearch')->name('income_statement_report.daily_report');
    Route::get('showroom-wise/expense-statement/daily', 'IncomeStateMentController@showroomReport')->name('showroom_wise.expense.daily');
    Route::get('showroom-wise/expense-statement/daily-search', 'IncomeStateMentController@showroomReportSearch')->name('showroom_wise.expense.daily.search');

    Route::get('balance-statement', 'BalanceStatementController@index')->name('balance_statement_report.index');
    Route::get('cashflow/index', 'CashFlowController@index')->name('cash_flow_report.index');

    Route::get('showroom-income-expense', 'IncomeStateMentController@showroom_income_expense_report')->name('showroom_income_expense_report.daily');
    Route::get('showroom-income-expense/search', 'IncomeStateMentController@showroom_income_expense_report_search')->name('showroom_income_expense_report.daily_search');

    Route::prefix('history')->group(function (): void {
        //Purchase
        Route::get('/purchase-index', 'HistoryController@purchaseHistory')->name('purchase.history')->middleware('permission');
        Route::get('/purchase-history-search', 'HistoryController@searchPurchase')->name('purchase.history.search');

        //Sale
        Route::get('/sale-index', 'HistoryController@saleHistory')->name('sale.history')->middleware('permission');
        Route::get('/sale-history-search', 'HistoryController@searchSale')->name('sale.history.search');
    });

    Route::prefix('accounts')->group(function (): void {
        Route::get('/supplier-bill-index', 'AccountsController@supplier')->name('supplier.bill')->middleware('permission');
        Route::get('/supplier-bill-search', 'AccountsController@supplierBill')->name('supplier.bill.search');

        Route::get('/customer-bill-index', 'AccountsController@customer')->name('customer.bill')->middleware('permission');
        Route::get('/customer-bill-search', 'AccountsController@customerBill')->name('customer.bill.search');
    });

    Route::prefix('staff-report')->group(function (): void {
        Route::get('/index', 'StaffReportController@index')->name('staff_report.index')->middleware('permission');

        Route::get('/search', 'StaffReportController@index')->name('staff_report.search_index');

        Route::get('/history/{id}', 'StaffReportController@showHistory')->name('staff_report.history');
    });

    Route::prefix('customer-report')->group(function (): void {
        Route::get('/index', 'CustomerReportController@index')->name('customer_report.index')->middleware('permission');

        Route::get('/history/{id}', 'CustomerReportController@showHistory')->name('customer_report.history');
    });

    Route::prefix('supplier-report')->group(function (): void {
        Route::get('/index', 'SupplierReportController@index')->name('supplier_report.index')->middleware('permission');

        Route::get('/history/{id}', 'SupplierReportController@showHistory')->name('supplier_report.history');
    });

    Route::prefix('retailer-report')->group(function (): void {
        Route::get('/index', 'RetailerReportController@index')->name('retailer_report.index')->middleware('permission');
    });

    Route::prefix('packing-report')->group(function (): void {
        Route::get('/index', 'ReportController@packingReport')->name('packing.report.index');
        Route::get('/search', 'ReportController@packingSearch')->name('packing.report.search');
        Route::get('/sent-products', 'ReportController@productPacking')->name('packing.report.product');
        Route::get('/recieve-products', 'ReportController@productRcvPacking')->name('packing.recieve_report.product');
        Route::get('/products-search', 'ReportController@productPackingSearch')->name('packing.product.search');
        Route::get('/recieve-products-search', 'ReportController@productRcvPackingSearch')->name('packing.recieve_report.search');
    });

    Route::get('/serial-no-index', 'ReportController@serial_index_report')->name('serial._product_report.index');
});
