<?php

use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function (): void {
    Route::get('/income/{id}/destroy1', 'IncomeController@destroy')->name('income.destroy1');
    Route::resource('/income', 'IncomeController');

    Route::get('/tranactions', 'TransactionController@index')->name('transaction.index')->middleware('permission');
    Route::get('/tranactions-delete/{id}', 'TransactionController@delete')->name('transaction.delete');

    Route::get('/tranactions/search', 'TransactionController@search')->name('transaction.search');

    Route::prefix('voucher')->group(function (): void {
        Route::middleware('permission')->group(function (): void {
            Route::get('/payment', 'VoucherController@index')->name('vouchers.index');
            Route::get('/payment-create', 'VoucherController@create')->name('vouchers.create');
            Route::post('/store', 'VoucherController@store')->name('vouchers.store');
            Route::post('/payment/{id}/update', 'VoucherController@update')->name('vouchers.update');
            Route::get('/detail/{id}/show', 'VoucherController@show')->name('vouchers.show');
            Route::get('/payments/{id}/edit', 'VoucherController@edit')->name('vouchers.edit');
            Route::get('/payments/{id}/destroy', 'VoucherController@destroy')->name('vouchers.destroy');

            Route::get('/recieve', 'VoucherRecieveController@index')->name('voucher_recieve.index');
            Route::get('/recieve-create', 'VoucherRecieveController@create')->name('voucher_recieve.create');
            Route::post('/recieve-store', 'VoucherRecieveController@store')->name('voucher_recieve.store');
            Route::get('/recieve/{id}/edit', 'VoucherRecieveController@edit')->name('voucher_recieve.edit');
            Route::post('/recieve/{id}/update', 'VoucherRecieveController@update')->name('voucher_recieve.update');
        });

        Route::post('/getPaymentsAccount', 'VoucherController@get_Accounts')->name('get_accounts_for_payment');
        Route::post('/get_invoice_lists', 'VoucherRecieveController@get_invoice_lists')->name('get_invoice_lists');

        Route::post('/getPaymentsAccount-config-type', 'VoucherRecieveController@get_accounts_configurable_type')->name('get_accounts_configurable_type');

        Route::get('/approval-list', 'VoucherController@approval_index')->name('voucher_approval.index')->middleware('permission');

        Route::post('/status-approval', 'VoucherController@approval_status')->name('set_voucher_approval');
        Route::get('/all-status-approval', 'VoucherController@allApproval')->name('voucher.all.approval');
        Route::post('/get-voucher-details', 'VoucherController@get_voucher_details')->name('get_voucher_details');
        Route::post('/get_voucher_details_form_statetment', 'VoucherController@get_voucher_details_form_statetment')->name('get_voucher_details_form_statetment');

        Route::middleware('permission')->group(function (): void {
            Route::get('/journal', 'JournalController@index')->name('journal.index');
            Route::get('/journal-create', 'JournalController@create')->name('journal.create');
            Route::post('/journal-store', 'JournalController@store')->name('journal.store');
            Route::get('/journal/{id}/edit', 'JournalController@edit')->name('journal.edit');
            Route::post('/journal/{id}/update', 'JournalController@update')->name('journal.update');

            Route::get('/contra-voucher', 'ContraVoucherController@index')->name('contra.index');
            Route::get('/contra-voucher-create', 'ContraVoucherController@create')->name('contra.create');
            Route::post('/contra-voucher-store', 'ContraVoucherController@store')->name('contra.store');
            Route::get('/contra-voucher/{id}/edit', 'ContraVoucherController@edit')->name('contra.edit');
            Route::post('/contra-voucher/{id}/update', 'ContraVoucherController@update')->name('contra.update');

            Route::get('/openning-balance', 'OpeningBalanceHistoryController@index')->name('openning_balance.index');
            Route::get('/openning-balance-create', 'OpeningBalanceHistoryController@create')->name('openning_balance.create');
            Route::post('/openning-balance-store', 'OpeningBalanceHistoryController@store')->name('openning_balance.store');
            Route::get('/openning-balance/{id}/edit', 'OpeningBalanceHistoryController@edit')->name('openning_balance.edit');
            Route::get('/openning-balance/{id}/destroy', 'OpeningBalanceHistoryController@delete')->name('openning_balance.destroy');
            Route::post('/openning-balance/{id}/update', 'OpeningBalanceHistoryController@update')->name('openning_balance.update');
            Route::post('/openning-balance/close', 'OpeningBalanceHistoryController@closeStatement')->name('openning_balance.closeStatement');
            Route::post('/openning-balance/showroom/store', 'OpeningBalanceHistoryController@showroom_openning_balance_store')->name('showroom_openning_balance.store');
        });
    });

    Route::middleware('permission')->group(function (): void {
        Route::get('/', 'AccountController@index')->name('char_accounts.index');
        Route::get('/chart-account-list', 'AccountController@create')->name('char_accounts.create');
        Route::post('/chart-account-store', 'AccountController@store')->name('char_accounts.store');
        Route::get('/chart-account/{id}/edit', 'AccountController@edit')->name('char_accounts.edit');
        Route::post('/chart-account/update/{id}', 'AccountController@update')->name('char_accounts.update');
        Route::get('/chart-account/destroy/{id}', 'AccountController@destroy')->name('char_accounts.destroy');
    });

    Route::get('/chart-account-list-parent', 'AccountController@parent_category')->name('chart_accounts.parent');

    Route::resource('bank_accounts', 'BankAccountController');
    Route::post('bank_accounts/update', 'BankAccountController@update')->name('bank.account.update');
    Route::post('bank_accounts/destroy', 'BankAccountController@destroy')->name('bank.account.delete');
    Route::get('bank_accounts/history/{id}', 'BankAccountController@showHistory')->name('bank.account.history');
    Route::get('/bank-accounts/csv-upload-page', 'BankAccountController@csv_upload')->name('bank.account.csv_upload');
    Route::post('/bank-accounts/csv-upload-store', 'BankAccountController@csv_upload_store')->name('bank.account.csv_upload_store');

    Route::get('profit', 'AccountBalanceController@income')->name('profit.index');

    Route::get('statement', 'GeneralLedgerController@index')->name('statement.index');

    Route::get('statement-filter-account/{id}', 'GeneralLedgerController@filterAccountBytype')->name('filterAccountBytype');
});

Route::get('/cashbooks', 'CashbookController@index')->name('cashbook.index');

Route::get('/account-balance', 'AccountBalanceController@index')->name('account.balance.index');

Route::get('/income-by-customer', 'AccountBalanceController@income_by_customer')->name('income_by_customer');

Route::get('/expense-by-supplier', 'AccountBalanceController@expense_by_supplier')->name('expense_by_supplier');

Route::get('/sale-tax', 'AccountBalanceController@sale_tax')->name('sale_tax');

Route::prefix('transfer')->group(function (): void {
    Route::get('/lists', 'TransferController@index')->name('transfer_showroom.index');
    Route::get('/create', 'TransferController@showroom_create')->name('transfer_showroom.create');
    Route::post('/store', 'TransferController@showroom_store')->name('transfer_showroom.store');
    Route::get('{id}/edit', 'TransferController@edit')->name('transfer_showroom.edit');
    Route::post('/{id}/update', 'TransferController@update')->name('transfer_showroom.update');
});

Route::post('/chart-account/update-info', 'AccountController@rename_account')->name('char_accounts.rename_account');
