<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::prefix('popup')->group(function (): void {
});

Route::get('/home', function () {
    return redirect('/');
});
Route::get('/', 'HomeController@index');
Route::get('/t/{kode}/{t}/{qty}', 'TrackingController@index');
Route::get('scannerawb/{status}', 'ScannerController@awb')->middleware(['auth', 'admin.agen.kurir']);
Route::get('scannerawb-test/{status}', 'ScannerController@awbtest')->middleware(['auth', 'admin.agen.kurir']);
Route::get('scannermanifest/{status}', 'ScannerController@manifest')->middleware(['auth', 'admin.agen.kurir']);

Route::prefix('log')->group(function (): void {
    Route::get('/', 'LogController@index');
    Route::get('datatables', 'LogController@datatables');
    Route::post('modal-new', 'LogController@modalNew');
    Route::post('modal-update', 'LogController@modalUpdate');
});
Route::get('qr-code-g', function () {
    QrCode::size(500)->format('png')->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));

    return view('qrCode');
});
Route::middleware(['auth'])->prefix('printout')->group(function (): void {
    Route::get('/invoice/{id}', 'PrintoutController@invoice');
    Route::get('/manifest/{id}', 'PrintoutController@manifest');
    Route::get('/awb/{id}', 'PrintoutController@awb');
    Route::get('/awbtri/{id}', 'PrintoutController@awbtri');
});

Route::prefix('master')->group(function (): void {
    Route::middleware(['auth', 'admin'])->prefix('invoice')->group(function (): void {
        Route::get('/', 'Master\InvoiceController@index');
        Route::get('/create', 'Master\InvoiceController@create');
        Route::get('/grouping', 'Master\InvoiceController@grouping');
        Route::post('/update', 'Master\InvoiceController@update');
        Route::post('/save', 'Master\InvoiceController@save');
        Route::post('/delete', 'Master\InvoiceController@delete');
        Route::get('/datatables', 'Master\InvoiceController@datatables');
        Route::post('/updatestatus', 'Master\InvoiceController@updatestatus');
        Route::post('/gantipassword', 'Master\InvoiceController@gantipassword');
        Route::get('/checkusername', 'Master\InvoiceController@checkusername');
        Route::get('/edit/{idcust} ', 'Master\InvoiceController@edit');
    });
    Route::middleware(['auth', 'admin.agen.driver'])->prefix('manifest')->group(function (): void {
        Route::get('/', 'Master\ManifestController@index');
        Route::get('/create', 'Master\ManifestController@create');
        Route::get('/grouping', 'Master\ManifestController@grouping');
        Route::post('/update', 'Master\ManifestController@update');
        Route::post('/save', 'Master\ManifestController@save');
        Route::post('/delete', 'Master\ManifestController@delete');
        Route::get('/datatables', 'Master\ManifestController@datatables');
        Route::post('/updatestatus', 'Master\ManifestController@updatestatus');
        Route::get('/edit/{kotaasal}/{kotatujuan}/{agentujuan}', 'Master\ManifestController@edit');
    });
    Route::middleware(['auth', 'admin.customer'])->prefix('alamat')->group(function (): void {
        Route::get('/', 'Master\AlamatController@index');
        Route::get('/create', 'Master\AlamatController@create');
        Route::get('/edit/{id}', 'Master\AlamatController@edit');
        Route::post('/update', 'Master\AlamatController@update');
        Route::post('/save', 'Master\AlamatController@save');
        Route::post('/delete', 'Master\AlamatController@delete');
        Route::get('/datatables', 'Master\AlamatController@datatables');
    });
    Route::middleware(['auth', 'admin'])->prefix('kecamatan')->group(function (): void {
        Route::get('/', 'Master\KecamatanController@index');
        Route::get('/create', 'Master\KecamatanController@create');
        Route::get('/edit/{id}', 'Master\KecamatanController@edit');
        Route::post('/update', 'Master\KecamatanController@update');
        Route::post('/save', 'Master\KecamatanController@save');
        Route::post('/delete', 'Master\KecamatanController@delete');
        Route::get('/datatables', 'Master\KecamatanController@datatables');
    });
    Route::middleware(['auth', 'admin'])->prefix('kota')->group(function (): void {
        Route::get('/', 'Master\KotaController@index');
        Route::get('/create', 'Master\KotaController@create');
        Route::get('/edit/{id}', 'Master\KotaController@edit');
        Route::post('/update', 'Master\KotaController@update');
        Route::post('/save', 'Master\KotaController@save');
        Route::post('/delete', 'Master\KotaController@delete');
        Route::get('/datatables', 'Master\KotaController@datatables');
    });
    Route::middleware(['auth', 'admin'])->prefix('users')->group(function (): void {
        Route::get('/', 'Master\UsersController@index');
        Route::get('/create', 'Master\UsersController@create');
        Route::get('/edit/{id}', 'Master\UsersController@edit');
        Route::post('/update', 'Master\UsersController@update');
        Route::post('/save', 'Master\UsersController@save');
        Route::post('/delete', 'Master\UsersController@delete');
        Route::get('/datatables', 'Master\UsersController@datatables');
        Route::get('/checkusername', 'Master\UsersController@checkusername');
    });
    Route::post('gantipassword', 'Master\UsersController@gantipassword')->middleware(['auth']);
    Route::middleware(['auth', 'admin'])->prefix('customer')->group(function (): void {
        Route::get('/', 'Master\CustomerController@index');
        Route::get('/create', 'Master\CustomerController@create');
        Route::get('/edit/{id}', 'Master\CustomerController@edit');
        Route::post('/update', 'Master\CustomerController@update');
        Route::post('/save', 'Master\CustomerController@save');
        Route::post('/delete', 'Master\CustomerController@delete');
        Route::get('/datatables', 'Master\CustomerController@datatables');
    });

    Route::middleware(['auth', 'admin'])->prefix('agen')->group(function (): void {
        Route::get('/', 'Master\AgenController@index');
        Route::get('/datatables', 'Master\AgenController@datatables');
        Route::post('/save', 'Master\AgenController@save');
        Route::post('/edit', 'Master\AgenController@edit');
        Route::post('/update', 'Master\AgenController@update');
        Route::post('/delete', 'Master\AgenController@delete');
    });
});

Route::middleware(['auth'])->prefix('awb')->group(function (): void {
    Route::middleware(['admin.customer'])->get('/', 'AwbController@index');
    Route::middleware(['admin.customer', 'booked'])->get('/edit/{id}/{hilang}', 'AwbController@edit');
    Route::middleware(['admin.customer'])->post('/save', 'AwbController@save');
    Route::middleware(['admin.customer'])->post('/delete', 'AwbController@delete');
    Route::middleware(['admin.customer'])->post('/manifest', 'AwbController@manifest');
    Route::middleware(['admin.customer'])->post('/koli', 'AwbController@koli');
    Route::middleware(['admin.customer'])->post('/show', 'AwbController@show');
    Route::middleware(['admin.customer'])->post('/filter-data-penerima', 'AwbController@filter_data_penerima');
    Route::middleware(['admin.customer'])->post('/filter-kota-agen', 'AwbController@filter_kota_agen');
    Route::middleware(['admin.customer'])->get('/datatables', 'AwbController@datatables');
    Route::middleware(['admin.customer'])->post('/filter-customer', 'AwbController@filter_customer');
    Route::middleware(['admin.customer'])->post('/filter-alamat', 'AwbController@filter_alamat');
    // Route::middleware(['admin.customer'])->get('/update-harga/{id}','AwbController@updateHarga');
    Route::middleware(['admin.agen.kurir'])->post('/updatetomanifest', 'AwbController@updatetomanifest');
    Route::middleware(['admin.agen.kurir'])->post('/updateawb', 'AwbController@updateawb');
    Route::middleware(['admin.agen.kurir'])->post('/updatediterima', 'AwbController@updatediterima');
    Route::middleware(['admin.agen.kurir'])->post('/updatemanifestqr', 'AwbController@updatemanifestqr');
});

Route::middleware(['auth'])->prefix('report')->group(function (): void {
    Route::get('awb', 'ReportController@awb')->middleware(['admin.agen.customer']);
    Route::post('awb-grid', 'ReportController@awb_grid');
    Route::get('manifest', 'ReportController@manifest')->middleware(['admin.agen']);
    Route::post('manifest-grid', 'ReportController@manifest_grid');
    Route::get('invoice', 'ReportController@invoice')->middleware(['admin']);
    Route::post('invoice-grid', 'ReportController@invoice_grid');
    Route::get('bonus', 'ReportController@bonus')->middleware(['admin']);
    Route::post('bonus-grid', 'ReportController@bonus_grid');
});

Route::prefix('ajax')->group(function (): void {
});
Route::prefix('cron')->group(function (): void {
});
Route::prefix('api')->group(function (): void {
});

Route::get('/download', function () {
    return view('download');
});
