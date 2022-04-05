<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('setup')->group(function (): void {
    Route::middleware('permission')->group(function (): void {
        Route::get('/country', 'CountryController@index')->name('country.index');
        Route::post('/country/store', 'CountryController@store')->name('country.store');
        Route::post('/country/edit', 'CountryController@edit')->name('country.edit');
        Route::put('/country/update/{id}', 'CountryController@update')->name('country.update');
        Route::get('/country/destroy/{id}', 'CountryController@destroy')->name('country.destroy');

        Route::get('/tax', 'TaxController@index')->name('tax.index');
        Route::post('/tax/store', 'TaxController@store')->name('tax.store');
        Route::get('/tax/{id}/edit', 'TaxController@edit')->name('tax.edit');
        Route::put('/tax/update/{id}', 'TaxController@update')->name('tax.update');
        Route::get('/tax/destroy/{id}', 'TaxController@destroy')->name('tax.destroy');
        Route::post('/update-active-status-tax', 'TaxController@update_active_status')->name('tax.update_active_status');

        Route::get('/introPrefix', 'IntroPrefixController@index')->name('introPrefix.index');
        Route::post('/introPrefix/store', 'IntroPrefixController@store')->name('introPrefix.store');
        Route::post('/introPrefix/edit', 'IntroPrefixController@edit')->name('introPrefix.edit');
        Route::put('/introPrefix/update/{id}', 'IntroPrefixController@update')->name('introPrefix.update');
        Route::get('/introPrefix/destroy/{id}', 'IntroPrefixController@destroy')->name('introPrefix.destroy');
        Route::get('/introPrefix/search', 'IntroPrefixController@index')->name('introPrefix.search_index');

        // printer
        Route::get('/printer', 'PrinterController@index')->name('printer.index');
        Route::post('/printer/store', 'PrinterController@store')->name('printer.store');
        Route::put('/printer/update/{id}', 'PrinterController@update')->name('printer.update');
        Route::get('/printer/edit/{id}', 'PrinterController@edit')->name('printer.edit');
        Route::get('/printer/delete/{id}', 'PrinterController@delete')->name('printer.delete');

        Route::post('ltr_rtl', 'SetupController@ltr_rtl')->name('ltr_rtl');
    });

    Route::get('/printer-getdata', 'PrinterController@getData')->name('printer.getdata');

    // Search

    Route::get('/tax/search', 'TaxController@index')->name('tax.search_index');
});

Route::prefix('hr')->group(function (): void {
    Route::get('/apply-loans', 'ApplyLoanController@index')->name('apply_loans.index');
    Route::get('/apply-loans/create', 'ApplyLoanController@create')->name('apply_loans.create');
    Route::post('/apply-loans/store', 'ApplyLoanController@store')->name('apply_loans.store');
    Route::post('/apply-loans/edit', 'ApplyLoanController@edit')->name('apply_loans.edit');
    Route::post('/apply-loans/show', 'ApplyLoanController@show')->name('apply_loans.show');
    Route::post('/apply-loans/update/{id}', 'ApplyLoanController@update')->name('apply_loans.update');
    Route::get('/apply-loans/destroy/{id}', 'ApplyLoanController@destroy')->name('apply_loans.destroy');
    Route::get('/apply-loans/history', 'ApplyLoanController@history')->name('apply_loans.history');
    Route::post('/apply-loans/user-details', 'ApplyLoanController@loanDetails')->name('user.loan.details');

    Route::group(['middleware' => ['auth', 'permission']], function (): void {
        Route::get('/loan-approval', 'ApplyLoanController@loan_approval_index')->name('apply_loans.loan_approval_index');
        Route::post('/loan-approval/show', 'ApplyLoanController@applied_show')->name('applied_loans.show');
        Route::post('/set-loan-approval', 'ApplyLoanController@change_approval')->name('set_approval_applied_loan');
    });

    Route::get('/departments', 'DepartmenController@index')->name('departments.index');
    Route::post('/departments-store', 'DepartmenController@store')->name('departments.store');
    Route::post('/departments-update', 'DepartmenController@update')->name('departments.update');
    Route::post('/departments-delete', 'DepartmenController@delete')->name('departments.delete');
});
