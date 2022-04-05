<?php

use App\Http\Controllers\AccessHistoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConsultController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\PayMethodController;
use App\Http\Controllers\PayPosController;
use App\Http\Controllers\PosInventoryController;
use App\Http\Controllers\PosRegisterController;
use App\Http\Controllers\PosRequestController;
use App\Http\Controllers\PosShipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileProcessController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\TradeMarkController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeAccountController;
use App\Http\Controllers\TypeCoinController;
use App\Http\Controllers\TypeStorageController;
use App\Http\Controllers\TypeTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('language/{lang?}', function ($lang = 'en') {
    session()->put('language', $lang);
    //return redirect()->back();
    return redirect('/home');
})->name('language');

Route::get('login/{msg?}', [UserController::class, 'login'])->name('login');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::post('login', [UserController::class, 'login'])->name('login.in');

Route::get('login_modal', [UserController::class, 'login_modal'])->middleware(['web'])->name('login.modal');
Route::get('end_login', [UserController::class, 'end_login'])->name('end_login');
Route::get('extend_login', [UserController::class, 'extend_login'])->name('extend_login');

Route::get('unauthenticated', function () {
    return view('errors.unauthenticated');
})->name('errors.unauthenticated');

Route::get('permission_denied', function () {
    return view('errors.permission_denied');
})->name('errors.permission_denied');

Route::match(['get', 'post'], 'password_change', [UserController::class, 'password_change'])->name('password_change');

Route::get('avatar/{code}', function ($code) {
    $path = storage_path('app' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $code . '.png');

    if (!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);

    return $response;
})->name('avatar');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }

    return redirect('/login');
})->name('main');

Route::get('get_dependents/{state_id}', [StateController::class, 'getAllDependent'])->name('getAllDependent');

Route::get('get_municipalities/{state_id}', [MunicipalityController::class, 'getMunicipalities'])->name('get_municipalities');
Route::get('get_cities/{state_id}', [CityController::class, 'getCities'])->name('get_cities');

Route::get('PO002.register2', [PosRegisterController::class, 'pos_register2'])->name('pos_register2');
Route::post('PO002.store2', [PosRegisterController::class, 'pos_register_store2'])->name('pos_register.store2');
Route::match(['get', 'post'], 'PO002.store_detail/{id}', [PosRegisterController::class, 'store_detail'])->name('pos_register.store_detail');

Route::group(['middleware' => ['auth', 'CheckPermision', 'DataImportant', 'CryptId']], function (): void {
    Route::get('theme/{theme?}', [UserController::class, 'theme'])->name('theme');
    Route::get('home', [UserController::class, 'home'])->name('home');

    Route::get('get_account/{code_bank?}', [AccountController::class, 'getAccount'])->name('get_account');

    // Users
    Route::get('U0001', [UserController::class, 'index'])->name('users');
    Route::get('U0001.create', [UserController::class, 'create'])->name('users.create');
    Route::get('U0001.edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('U0001.store', [UserController::class, 'store'])->name('users.store');
    Route::post('U0001.update', [UserController::class, 'update'])->name('users.update');
    Route::get('U0001.show_modal/{id}', [UserController::class, 'show_modal'])->name('users.show_modal');
    Route::get('U0001.lock_user/{id}', [UserController::class, 'lock_user'])->name('users.lock_user');
    Route::get('U0001.susp_user/{id}/{date_in}/{date_out}', [UserController::class, 'susp_user'])->name('users.susp_user');
    Route::get('U0001.unlock_user/{id}', [UserController::class, 'unlock_user'])->name('users.unlock_user');
    Route::get('U0001.reset_password/{id}', [UserController::class, 'reset_password'])->name('users.reset_password');
    Route::get('U0001.change_password', [UserController::class, 'change_password'])->name('users.change_password');
    Route::post('U0001.password_update', [UserController::class, 'password_update'])->name('users.password_update');
    Route::get('U0001.removeSus/{id}', [UserController::class, 'removeSus'])->name('users.removeSus');
    //Route::get('U0001.check_password/{password}', [UserController::class, 'check_password'])->name('users.check_password');
    Route::get('U0003', [UserController::class, 'index_logged_users'])->name('logged_users');
    Route::get('U0003.delete_logged/{id}', [UserController::class, 'delete_logged'])->name('users.delete_logged');

    Route::match(['get', 'post'], 'U0004', [UserController::class, 'restricted_access'])->name('restricted_access');
    Route::match(['get', 'post'], 'U0005', [UserController::class, 'access_history'])->name('access_history');
    Route::get('U0005.search_history_detail/{h_id}', [AccessHistoryController::class, 'search_history_detail'])->name('access_history.search_history_detail');
    Route::match(['get', 'post'], 'U0006', [UserController::class, 'failed_login'])->name('failed_login');

    Route::get('U0007', [UserController::class, 'index_time_inactivity'])->name('time_inactivity');
    Route::post('U0007.createTimeInactivity', [UserController::class, 'createTimeInactivity'])->name('users.time_inactivity');

    // Profiles Routes
    Route::get('P0001', [ProfileController::class, 'index'])->name('profiles');
    Route::get('P0001.create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('P0001.store', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('P0001.edit/{id}', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::post('P0001.update', [ProfileController::class, 'update'])->name('profiles.update');
    Route::get('P0001.delete/{id}', [ProfileController::class, 'delete'])->name('profiles.delete');
    Route::get('P0001.reactivate/{id}', [ProfileController::class, 'reactivate'])->name('profiles.reactivate');

    // Profiles Process Routes
    Route::get('P0001.profile_process/{id}', [ProfileProcessController::class, 'index'])->name('profiles.process');
    Route::post('P0001.store.process', [ProfileProcessController::class, 'store'])->name('profiles.process.store');

    // Coin type Routes
    Route::get('M0001', [TypeCoinController::class, 'index'])->name('typeCoin');
    Route::post('M0001.store', [TypeCoinController::class, 'store'])->name('typeCoin.store');
    Route::get('M0001.create', [TypeCoinController::class, 'create'])->name('typeCoin.create');
    Route::get('M0001.edit/{id}', [TypeCoinController::class, 'edit'])->name('typeCoin.edit');
    Route::post('M0001.update', [TypeCoinController::class, 'update'])->name('typeCoin.update');
    Route::get('M0001.delete/{id}', [TypeCoinController::class, 'delete'])->name('typeCoin.delete');
    Route::get('M0001.activate/{id}', [TypeCoinController::class, 'activate'])->name('typeCoin.activate');
    Route::get('M0001.change_status/{id}/{action?}', [TypeCoinController::class, 'change_status'])->name('typeCoin.change_status');

    // Store type Routes
    Route::get('M0002', [TypeStorageController::class, 'index'])->name('typeStore');
    Route::get('M0002.create', [TypeStorageController::class, 'create'])->name('typeStore.create');
    Route::get('M0002.edit/{id}', [TypeStorageController::class, 'edit'])->name('typeStore.edit');
    Route::post('M0002.store', [TypeStorageController::class, 'store'])->name('typeStore.store');
    Route::post('M0002.update', [TypeStorageController::class, 'update'])->name('typeStore.update');
    Route::get('M0002.change_status/{id}/{action?}', [TypeStorageController::class, 'change_status'])->name('typeStore.change_status');

    // Storages Routes
    Route::get('M0003', [StorageController::class, 'index'])->name('storage');
    Route::get('M0003.showRegister', [StorageController::class, 'showRegister'])->name('storage.showRegister');
    Route::post('M0003.create', [StorageController::class, 'create'])->name('storage.create');
    Route::get('M0003.showEdit/{id}', [StorageController::class, 'showEdit'])->name('storage.showEdit');
    Route::post('M0003.edit', [StorageController::class, 'edit'])->name('storage.edit');
    Route::get('M0003.change_status_Storages/{id}/{action?}', [StorageController::class, 'change_status_Storages'])->name('storage.change_status_Storages');

    // Trade Mark Routes
    Route::get('M0004', [TradeMarkController::class, 'index'])->name('trade_marks');
    Route::get('M0004.showRegister', [TradeMarkController::class, 'showRegister'])->name('trade_marks.showRegister');
    Route::post('M0004.create', [TradeMarkController::class, 'create'])->name('trade_marks.create');
    Route::get('M0004.showEdit/{id}', [TradeMarkController::class, 'showEdit'])->name('trade_marks.showEdit');
    Route::post('M0004.edit', [TradeMarkController::class, 'edit'])->name('trade_marks.edit');
    Route::get('M0004.change_status_trade_marks/{id}/{action?}', [TradeMarkController::class, 'change_status_trade_marks'])->name('trade_marks.change_status_trade_marks');

    // Models Routes
    Route::get('M0005', [ModelController::class, 'index'])->name('models');
    Route::get('M0005.showRegister', [ModelController::class, 'showRegister'])->name('models.showRegister');
    Route::post('M0005.create', [ModelController::class, 'create'])->name('models.create');
    Route::get('M0005.showEdit/{id}', [ModelController::class, 'showEdit'])->name('models.showEdit');
    Route::post('M0005.edit', [ModelController::class, 'edit'])->name('models.edit');
    Route::get('M0005.change_status_models/{id}/{action?}', [ModelController::class, 'change_status_models'])->name('models.change_status_models');

    // Type Acount Routes
    Route::get('M0006', [TypeAccountController::class, 'index'])->name('type_account');
    Route::get('M0006.showRegister', [TypeAccountController::class, 'showRegister'])->name('type_account.showRegister');
    Route::post('M0006.create', [TypeAccountController::class, 'create'])->name('type_account.create');
    Route::get('M0006.showEdit/{id}', [TypeAccountController::class, 'showEdit'])->name('type_account.showEdit');
    Route::post('M0006.edit', [TypeAccountController::class, 'edit'])->name('type_account.edit');
    Route::get('M0006.change_status_account/{id}/{action?}', [TypeAccountController::class, 'change_status_account'])->name('type_account.change_status_account');

    // Type transactions Routes
    Route::get('M0007', [TypeTransactionController::class, 'index'])->name('type_transactions');
    Route::get('M0007.create', [TypeTransactionController::class, 'create'])->name('type_transactions.create');
    Route::post('M0007.store', [TypeTransactionController::class, 'store'])->name('type_transactions.store');
    Route::get('M0007.edit/{id}', [TypeTransactionController::class, 'edit'])->name('type_transactions.edit');
    Route::post('M0007.update', [TypeTransactionController::class, 'update'])->name('type_transactions.update');
    Route::get('M0007.change_status/{id}/{type}', [TypeTransactionController::class, 'change_status'])->name('type_transactions.change_status');

    // Type transactions Routes
    Route::get('M0008', [TransactionController::class, 'index'])->name('transactions');
    Route::get('M0008.create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('M0008.store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('M0008.edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::post('M0008.update', [TransactionController::class, 'update'])->name('transactions.update');
    Route::get('M0008.change_status/{id}/{type}', [TransactionController::class, 'change_status'])->name('transactions.change_status');

    // Pay Method Routes
    Route::get('M0009', [PayMethodController::class, 'index'])->name('pay_methods');
    Route::get('M0009.showRegister', [PayMethodController::class, 'showRegister'])->name('pay_methods.showRegister');
    Route::post('M0009.create', [PayMethodController::class, 'create'])->name('pay_methods.create');
    Route::get('M0009.showEdit/{id}', [PayMethodController::class, 'showEdit'])->name('pay_methods.showEdit');
    Route::post('M0009.edit', [PayMethodController::class, 'edit'])->name('pay_methods.edit');
    Route::get('M0009.change_status_method_pay/{id}/{action?}', [PayMethodController::class, 'change_status_method_pay'])->name('pay_methods.change_status_method_pay');

    // Franchises Routes
    Route::get('M0010', [FranchiseController::class, 'index'])->name('franchise');
    Route::get('M0010.create', [FranchiseController::class, 'create'])->name('franchise.create');
    Route::post('M0010.store', [FranchiseController::class, 'store'])->name('franchise.store');
    Route::get('M0010.edit/{id}', [FranchiseController::class, 'edit'])->name('franchise.edit');
    Route::post('M0010.update', [FranchiseController::class, 'update'])->name('franchise.update');
    Route::get('M0010.change_status/{id}/{type}', [FranchiseController::class, 'change_status'])->name('franchise.change_status');

    // Banks Routes
    Route::get('C0001', [BankController::class, 'index'])->name('banks');
    Route::get('C0001.create', [BankController::class, 'create'])->name('banks.create');
    Route::post('C0001.searchIca', [BankController::class, 'searchIca'])->name('banks.searchIca');
    Route::post('C0001.searchIcabin', [BankController::class, 'searchIcabin'])->name('banks.searchIcabin');
    Route::post('C0001.searchIcaProcess', [BankController::class, 'searchIcaProcess'])->name('banks.searchIcaProcess');
    Route::post('C0001.store', [BankController::class, 'store'])->name('banks.store');
    Route::post('C0001.storeBinProcess', [BankController::class, 'storeBinProcess'])->name('banks.storeBinProcess');
    Route::get('C0001.icaProcess/{id}', [BankController::class, 'icaProcess'])->name('banks.icaProcess');
    Route::get('C0001.edit/{id}', [BankController::class, 'edit'])->name('banks.edit');
    Route::post('C0001.edit', [BankController::class, 'editIca'])->name('banks.editIca');
    Route::post('C0001.update', [BankController::class, 'update'])->name('banks.update');
    Route::post('C0001.updateIca', [BankController::class, 'updateIca'])->name('banks.updateIca');
    Route::post('C0001.updateIcaBin', [BankController::class, 'updateIcaBin'])->name('banks.updateIcaBin');
    Route::post('C0001.updateIcaProcess', [BankController::class, 'updateIcaProcess'])->name('banks.updateIcaProcess');
    Route::get('C0001.delete/{id}', [BankController::class, 'delete'])->name('banks.delete');
    Route::get('P0001.deleteica/{id}', [BankController::class, 'deleteIca'])->name('banks.deleteIca');
    Route::get('P0001.deletebin/{id}', [BankController::class, 'deleteBin'])->name('banks.deleteBin');
    Route::get('P0001.deleteprocess/{id}', [BankController::class, 'deleteProcess'])->name('banks.deleteProcess');
    Route::get('C0001.reactivate/{id}', [BankController::class, 'reactivate'])->name('banks.reactivate');
    Route::get('P0001.reactivateica/{id}', [BankController::class, 'reactivateIca'])->name('banks.reactivateIca');
    Route::get('P0001.reactivatebin/{id}', [BankController::class, 'reactivateBin'])->name('banks.reactivateBin');
    Route::get('P0001.reactivateprocess/{id}', [BankController::class, 'reactivateProcess'])->name('banks.reactivateProcess');

    // Agencies Routes
    Route::get('C0002', [AgencyController::class, 'index'])->name('agency');
    Route::get('C0002.create', [AgencyController::class, 'create'])->name('agency.create');
    Route::post('C0002.store', [StorageController::class, 'store'])->name('agency.store');
    Route::get('C0002.edit/{id}', [AgencyController::class, 'edit'])->name('agency.edit');
    Route::post('C0002.update', [StorageController::class, 'update'])->name('agency.update');
    Route::get('C0002.change_status/{id}/{action}', [StorageController::class, 'change_status'])->name('agency.change_status');

    // ADMIN POS
    Route::get('PO002.register', [PosRegisterController::class, 'pos_register'])->name('pos_register');

    Route::post('PO002.store', [PosRegisterController::class, 'pos_register_store'])->name('pos_register.store');
    Route::post('PO002.excel', [PosRegisterController::class, 'save_excel'])->name('pos_register.excel');

    Route::get('PO008', [PosRegisterController::class, 'pos_register_edit'])->name('pos_register_edit');
    Route::post('PO008.consult_boxes_search', [PosRegisterController::class, 'consult_boxes_search'])->name('pos_register_edit.search');
    Route::get('PO008.updateRegisterBoxes/{id}', [PosRegisterController::class, 'updateRegisterBoxes'])->name('pos_register_edit.updateRegisterBoxes');
    Route::post('PO008.clearAll', [PosRegisterController::class, 'clearAll'])->name('pos_register_edit.clearAll');

    Route::post('PO004.search', [PosShipmentController::class, 'searchBox'])->name('pos_send_request.search');

    Route::get('PO004.list_data_search/{pos_request?}', [PosShipmentController::class, 'list_requested_data'])->name('pos_send_request.list_data_search');

    Route::post('PO004.registerShipmentPos', [PosShipmentController::class, 'registerShipmentPos'])->name('pos_send_request.registerShipmentPos');

    Route::get('PO003.request', [PosRequestController::class, 'pos_request'])->name('pos_request');
    Route::post('PO003.store', [PosRequestController::class, 'pos_request_store'])->name('pos_request.store');
    Route::get('PO003.containerPDF/{id}', [PosRequestController::class, 'containerPDF'])->name('pos_request.containerPDF');
    Route::get('PO003.viewPDF/{id}', [PosRequestController::class, 'pos_request_viewPDF'])->name('pos_request.viewPDF');
    Route::get('PO003.consult_available/{store}', [PosRequestController::class, 'show_consult_available'])->name('pos_request.consult_available');

    Route::get('PO004', [PosShipmentController::class, 'pos_send_request'])->name('pos_send_request');
    Route::get('PO004.consult_available', [PosShipmentController::class, 'show_consult_available'])->name('pos_send_request.consult_available');
    Route::get('PO004.containerPDF/{id}', [PosShipmentController::class, 'containerPDF'])->name('pos_send_request.shipmentContainerPDF');
    Route::get('PO004.viewPDF/{id}', [PosShipmentController::class, 'pos_send_viewPDF'])->name('pos_send_request.shipmentPDF');

    Route::get('PO005', [PosShipmentController::class, 'pos_reception'])->name('pos_reception');
    Route::get('PO005.search/{num_request}', [PosShipmentController::class, 'search'])->name('pos_reception.search');
    Route::get('PO005.shipment_search/{shipment}', [PosShipmentController::class, 'shipment_search'])->name('pos_reception.shipment_search');
    Route::post('PO005.store', [PosShipmentController::class, 'store'])->name('pos_reception.store');

    Route::get('PO006', [PosInventoryController::class, 'pos_adaptation'])->name('pos_adaptation');
    Route::get('PO006.search/{boxes?}', [PosInventoryController::class, 'search'])->name('pos_adaptation.search');
    Route::get('PO006.serial_search/{id}', [PosInventoryController::class, 'serial_search'])->name('pos_adaptation.serial_search');
    Route::get('PO006.search_model', [PosInventoryController::class, 'search_model'])->name('pos_adaptation.search_model');
    Route::get('PO006.show_serial/{serial?}', [PosInventoryController::class, 'show_serial'])->name('pos_adaptation.show_serial');
    Route::post('PO006.store', [PosInventoryController::class, 'store'])->name('pos_adaptation.store');
    Route::post('PO006.detailed_store', [PosInventoryController::class, 'detailed_store'])->name('pos_adaptation.detailed_store');

    Route::get('PO007', [PosInventoryController::class, 'pos_configuration'])->name('pos_configuration');
    Route::get('PO007.SearchForConfig/{boxes?}', [PosInventoryController::class, 'SearchForConfig'])->name('pos_configuration.SearchForConfig');
    Route::post('PO007.configured_store', [PosInventoryController::class, 'configured_store'])->name('pos_configuration.configured_store');

    // ADMIN CLIENTS
    // Register of Client
    Route::get('CL001', [ClientController::class, 'index'])->name('client');
    Route::post('CL001.search_client', [ClientController::class, 'search_client'])->name('client.search_client');
    Route::post('CL001.get_data_client', [ClientController::class, 'getDataClient'])->name('client.getDataClient');
    Route::get('CL001.generateAccount', [ClientController::class, 'generateAccount'])->name('client.generateAccount');
    Route::post('CL001.storeAccount', [ClientController::class, 'storeAccount'])->name('client.storeAccount');
    //Route::get('CL001.search_representatives', [ClientController::class, 'search_representatives'])->name('client.search_representatives');
    Route::get('CL001.search_representatives/{type}/{document}', [ClientController::class, 'search_representatives'])->name('client.search_representatives');
    Route::post('CL001.decision', [ClientController::class, 'decision'])->name('client.decision');
    Route::get('CL001.form_natural_person', [ClientController::class, 'form_natural_person'])->name('client.form_natural_person');
    Route::get('CL001.form_juridic_person', [ClientController::class, 'form_juridic_person'])->name('client.form_juridic_person');
    Route::post('CL001.store_person_natural', [ClientController::class, 'store_person_natural'])->name('client.store_person_natural');
    Route::post('CL001.store_person_juridic', [ClientController::class, 'store_person_juridic'])->name('client.store_person_juridic');
    Route::post('CL001.search_representatives', [ClientController::class, 'client.search_representatives'])->name('client.search_representatives');

    Route::get('CL002', [ClientController::class, 'pre_opening_account'])->name('pre_opening_account');

    // Update of Client
    Route::get('CL003', [ClientController::class, 'edit'])->name('client_edit');
    Route::post('CL003.search_client_edit/{type_consult?}', [ClientController::class, 'search_client_edit'])->name('client_edit.search_client_edit');
    Route::post('CL003.update_person_natural', [ClientController::class, 'update_person_natural'])->name('client.update_person_natural');
    Route::post('CL003.update_person_juridic', [ClientController::class, 'update_person_juridic'])->name('client.update_person_juridic');

    Route::get('CL004', [ClientController::class, 'pos_assignment'])->name('pos_assignment');
    Route::get('CL004.get_pos/{serial}', [PosInventoryController::class, 'get_pos'])->name('pos_assignment.get_pos');
    Route::get('CL004.get_pos_price/{serial}', [PosInventoryController::class, 'get_pos_price'])->name('pos_assignment.get_pos_price');
    Route::post('CL004.save_pos_client', [ClientController::class, 'save_pos_client'])->name('pos_assignment.save_pos_client');

    // Charge POS
    Route::get('CL005', [PayPosController::class, 'index'])->name('charge_pos');
    Route::post('CL005.search_client', [PayPosController::class, 'search_client'])->name('charge_pos.search_client');
    Route::get('CL005.search_pay/{id}', [PayPosController::class, 'search_pay'])->name('charge_pos.search_pay');

    // REQUEST
    Route::get('RQ0001', [ConsultController::class, 'consult_pos'])->name('consult');
    Route::get('RQ0002', [ConsultController::class, 'consult_Request_pos'])->name('consult2');
    Route::get('RQ0003', [ConsultController::class, 'consult_client'])->name('consult_client');
    Route::post('RQ0001.consult_pos_searh', [ConsultController::class, 'consult_pos_search'])->name('consult.consult_pos_searh');
    Route::get('RQ0001.detail_pos/{id1}', [ConsultController::class, 'detail_pos'])->name('consult.detail_pos');
    Route::get('RQ0002.consult_request_pos_detail', [ConsultController::class, 'consult_request_pos_detail'])->name('consult2.consult_request_pos_detail');
    Route::get('RQ0002.consult_request_pos_search/{number}', [ConsultController::class, 'consult_request_pos_search'])->name('consult2.consult_request_pos_search');
    Route::get('RQ0001.view_graphic/{storage_id}', [ConsultController::class, 'view_graphic'])->name('consult.view_graphic');
});

/*

Route::get('/', function () {


      //create pdf document
      $pdf = new Crabbly\Fpdf\Fpdf;
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(40,10,'Hello World!');
      $pdf->Output(); exit;
      //save file
      //Storage::put($pdf->Output('S'));


    //   dompdf PDF

      $data = [
      'titulo' => 'Styde.net'
      ];

      $pdf = \PDF::loadView('reports.test.pdf', $data);

      return $pdf->download('archivo.pdf');



    return view('layouts.default');
});
*/
