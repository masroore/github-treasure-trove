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

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/login');
})->name('logout');

/*
Route::get('/', function () {
    return redirect('/login');
});
*/

Auth::routes();
//Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

    Route::group(['prefix' => 'org'], function (): void {
        Route::get('userPrivilege', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'userPrivilege']);
        Route::get('userInfoListView', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'userInfoListView']);
        Route::post('memberList', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'getUserInfoList']);
        Route::get('memberadd', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'addMemberinfo'])->name('org.add');
        Route::post('memberadder', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'addMember']);
        Route::post('upload', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'upload']);
        Route::post('memberupdate', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'updateMember']);
        Route::post('memberInfo/delete', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'deleteMember']);
        Route::get('privilege', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'addPrivilege']);
        Route::post('storePrivilege', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'storePrivilege']);
        Route::get('system/backup', [App\Http\Controllers\OrgManage\BackupController::class, 'index']);
        Route::get('system/settings', [App\Http\Controllers\OrgManage\SettingsController::class, 'index'])->name('system.settings');
        Route::post('system/updateSettings', [App\Http\Controllers\OrgManage\OrgmanageController::class, 'updateSettings']);
    });

    Route::group(['prefix' => 'decision'], function (): void {
        Route::get('/', [App\Http\Controllers\Decision\DecisionController::class, 'index']);
        Route::get('receivedReport', [App\Http\Controllers\Decision\DecisionController::class, 'receivedReport'])->name('decision.report');
        Route::get('draftReport', [App\Http\Controllers\Decision\DecisionController::class, 'draftReport']);
        Route::get('redirect', [App\Http\Controllers\Decision\DecisionController::class, 'redirect']);
        Route::post('report/submit', [App\Http\Controllers\Decision\DecisionController::class, 'reportSubmit']);
        Route::post('getACList', [App\Http\Controllers\Decision\DecisionController::class, 'getACList']);
        Route::get('analyzeReport', [App\Http\Controllers\Decision\DecisionController::class, 'analyzeReport'])->name('decision.analyze');
    });

    Route::group(['prefix' => 'ajax'], function (): void {
        Route::post('decide/receive', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxGetReceive']);
        Route::post('report/decide', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxReportDecide']);
        Route::post('report/detail', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxReportDetail']);
        Route::post('report/getData', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxReportData']);
        Route::post('report/fileupload', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxReportFile']);
        Route::post('decide/noattachments', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxNoAttachments']);

        Route::post('object', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxObject']);
        Route::post('report/attachment/delete', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxDeleteReportAttach']);
        Route::post('report/delete', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxDelete']);
        Route::post('decide/draft', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxGetDraft']);
        Route::get('check/report', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxCheckReport']);
        Route::post('report/analyze', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxAnalyzeReport']);

        Route::post('ship/voyList', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxGetVoyList']);
        Route::post('profit/list', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxProfitList']);
        Route::post('getDepartment', [App\Http\Controllers\Decision\DecisionController::class, 'ajaxGetDepartment']);
        Route::post('getDynamicData', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxGetDynamicData']);
        Route::post('setDynamicData', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxSetDynamicData']);
        Route::post('shipMember/listAll', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxGetWholeList']);
        Route::post('shipMember/search', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxSearchMember']);
        Route::post('shipMember/searchAll', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxSearchMemberAll']);
        Route::post('shipMember/searchWageById', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxSearchWageById']);
        Route::post('shipMember/cert/list', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxShipMemberCertList']);
        Route::post('shipMember/wage/list', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxSearchMemberWithWage']);
        Route::post('shipMember/wage/send', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxSearchMemberWithSendWage']);
        Route::post('shipMember/wage/shiplist', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxGetShipWageList']);
        Route::post('shipMember/wage/memberlist', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'ajaxGetShipMemberList']);
        Route::post('shipMember/wage/initCalc', [App\Http\Controllers\ShipManage\WageController::class, 'initWageCalcInfo']);
        Route::post('shipMember/wage/initSend', [App\Http\Controllers\ShipManage\WageController::class, 'initWageSendInfo']);
        Route::get('shipMember/autocomplete', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'autocomplete']);
        Route::get('shipMember/autocompleteAll', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'autocompleteAll']);
        Route::get('shipMember/getCount', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'getCount']);

        Route::post('shipManage/material/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipMaterialList']);
        Route::post('shipManage/material/category/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxMaterialCategoryItemDelete']);
        Route::post('shipManage/material/type/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxMaterialTypeItemDelete']);
        Route::post('shipManage/shipMaterial/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipMaterialDelete']);

        Route::post('shipManage/cert/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipCertList']);
        Route::post('shipManage/cert/add', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxCertAdd']);
        Route::post('shipManage/cert/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxCertItemDelete']);
        Route::post('shipManage/shipCert/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipCertDelete']);
        Route::post('shipManage/dynamic/search', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxDynamicSearch']);
        Route::post('shipManage/equipment/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxEquipmentList']);
        Route::post('shipManage/equipment/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipEquipDelete']);
        Route::post('shipManage/equipment/require/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxReqEquipmentList']);
        Route::post('shipManage/equipment/require/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipReqEquipDelete']);
        Route::post('shipManage/equipment/require/type/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipReqEquipTypeList']);
        Route::post('shipManage/equipment/require/type/delete', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxShipReqEquipTypeDelete']);

        Route::post('shipManage/evaluation/list', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxEvaluation']);
        Route::post('shipManage/evaluation/else', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxEvaluationElse']);

        //Business
        Route::post('business/cp/list', [App\Http\Controllers\Business\BusinessController::class, 'ajaxCPList']);
        Route::post('business/cp/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoyDelete']);
        Route::post('business/contract/info', [App\Http\Controllers\Business\BusinessController::class, 'ajaxContractInfo']);
        Route::post('business/voyNo/validate', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoyNoValid']);
        Route::post('business/cargo/list', [App\Http\Controllers\Business\BusinessController::class, 'ajaxCargoList']);
        Route::post('business/cargo/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxCargoDelete']);
        Route::post('business/port/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxPortDelete']);
        Route::post('business/dynamic', [App\Http\Controllers\Business\BusinessController::class, 'ajaxDynamic']);
        Route::post('business/dynamic/list', [App\Http\Controllers\Business\BusinessController::class, 'ajaxDynamicList']);
        Route::post('business/dynrecord/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxDeleteDynrecord']);
        Route::post('business/voy/list', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoyAllList']);
        Route::post('business/dynamic/search', [App\Http\Controllers\Business\BusinessController::class, 'ajaxDynamicSearch']);
        Route::post('business/dynamic/multiSearch', [App\Http\Controllers\Business\BusinessController::class, 'ajaxDynamicMultiSearch']);
        Route::post('business/ctm/list', [App\Http\Controllers\Business\BusinessController::class, 'ajaxCtm']);
        Route::post('business/ctm/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxCtmDelete']);
        Route::post('shipmanage/ctm/total', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxCtmTotal']);
        Route::post('shipmanage/ctm/debit', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxCtmDebit']);
        Route::post('shipmanage/ctm/debits', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ajaxCtmDebits']);
        Route::post('business/voySettle/index', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoySettleIndex']);
        Route::post('business/voySettle/elseInfo/delete', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoySettleDelete']);
        Route::post('business/setttlement/clear', [App\Http\Controllers\Business\BusinessController::class, 'ajaxVoyClear']);
        Route::post('system/backup/list', [App\Http\Controllers\OrgManage\BackupController::class, 'getList']);
        Route::post('system/backup/add', [App\Http\Controllers\OrgManage\BackupController::class, 'add']);
        Route::post('system/backup/backup', [App\Http\Controllers\OrgManage\BackupController::class, 'backup']);
        Route::post('system/backup/restore', [App\Http\Controllers\OrgManage\BackupController::class, 'restore']);
        Route::post('system/backup/delete', [App\Http\Controllers\OrgManage\BackupController::class, 'delete']);
        Route::post('finance/books/list', [App\Http\Controllers\Finance\FinanceController::class, 'getBookList']);
        Route::post('finance/books/init', [App\Http\Controllers\Finance\FinanceController::class, 'initBookList']);
        Route::post('finance/waters/list', [App\Http\Controllers\Finance\FinanceController::class, 'getWaterList']);
        Route::post('finance/waters/find', [App\Http\Controllers\Finance\FinanceController::class, 'getWaterFind']);
        Route::post('finance/accounts/report/list', [App\Http\Controllers\Finance\FinanceController::class, 'getReportList']);
        Route::post('finance/accounts/analysis/list', [App\Http\Controllers\Finance\FinanceController::class, 'getAnalysisList']);
        Route::post('finance/accounts/info/list', [App\Http\Controllers\Finance\FinanceController::class, 'getPersonalInfoList']);
        Route::post('finance/accounts/setting/list', [App\Http\Controllers\Finance\FinanceController::class, 'getSettingList']);
        Route::post('operation/listByShipForPast', [App\Http\Controllers\Operation\OperationController::class, 'ajaxIncomeExportListByShipForPast']);		// dailyAverage
    Route::post('operation/listByShip', [App\Http\Controllers\Operation\OperationController::class, 'ajaxIncomeExportListByShip']);		// incomeExpense -> Table, Graph
    Route::post('operation/listBySOA', [App\Http\Controllers\Operation\OperationController::class, 'ajaxListBySOA']);					// incomeExpense -> SOA
    Route::post('operation/listByAll', [App\Http\Controllers\Operation\OperationController::class, 'ajaxListByAll']);					// incomeExpenseAll -> Table

    Route::post('check/shipType', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxCheckShipType']);
        Route::post('check/rankType', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxCheckRankType']);
        Route::post('check/capacityType', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxCheckCapacity']);
        Route::post('check/account', [App\Http\Controllers\Dynamic\DynamicController::class, 'ajaxCheckAccount']);

        Route::post('voy/total', [App\Http\Controllers\VoyLogController::class, 'ajaxGetVoyData']);
        Route::post('voy/totals', [App\Http\Controllers\VoyLogController::class, 'ajaxGetVoyDatas']);
    });

    Route::group(['prefix' => 'business'], function (): void {
        Route::get('contract', [App\Http\Controllers\Business\BusinessController::class, 'contract']);
        Route::post('voyContractRegister', [App\Http\Controllers\Business\BusinessController::class, 'saveVoyContract']);
        Route::post('saveCargoList', [App\Http\Controllers\Business\BusinessController::class, 'saveCargoList']);
        Route::post('savePortList', [App\Http\Controllers\Business\BusinessController::class, 'savePortList']);
        Route::post('tcContractRegister', [App\Http\Controllers\Business\BusinessController::class, 'saveTcContract']);
        Route::post('nonContractRegister', [App\Http\Controllers\Business\BusinessController::class, 'saveNonContract']);
        Route::get('dynRecord', [App\Http\Controllers\Business\BusinessController::class, 'dynRecord']);
        Route::post('saveDynamic', [App\Http\Controllers\Business\BusinessController::class, 'saveDynamic']);
        Route::get('settleMent', [App\Http\Controllers\Business\BusinessController::class, 'settleMent']);
        Route::post('saveVoySettle', [App\Http\Controllers\Business\BusinessController::class, 'saveVoySettle']);
        Route::get('ctm', [App\Http\Controllers\Business\BusinessController::class, 'ctm']);
        Route::post('saveCtmList', [App\Http\Controllers\Business\BusinessController::class, 'saveCtmList']);
        Route::get('dailyAverageCost', [App\Http\Controllers\Business\BusinessController::class, 'dailyAverageCost']);
        Route::post('updateCostInfo', [App\Http\Controllers\Business\BusinessController::class, 'updateCostInfo']);
    });

    Route::group(['prefix' => 'finance'], function (): void {
        Route::get('books', [App\Http\Controllers\Finance\FinanceController::class, 'books']);
        Route::get('accounts', [App\Http\Controllers\Finance\FinanceController::class, 'accounts']);
        Route::post('books/save', [App\Http\Controllers\Finance\FinanceController::class, 'saveBookList']);
        Route::post('accounts/info/save', [App\Http\Controllers\Finance\FinanceController::class, 'savePersonalInfoList']);
        Route::post('accounts/setting/save', [App\Http\Controllers\Finance\FinanceController::class, 'saveSettingList']);
    });

    Route::group(['prefix' => 'operation'], function (): void {
        Route::get('incomeExpense', [App\Http\Controllers\Operation\OperationController::class, 'incomeExpense'])->name('income.ship');
        Route::get('incomeAllExpense', [App\Http\Controllers\Operation\OperationController::class, 'incomeAllExpense'])->name('income.all');
    });
    Route::group(['prefix' => 'shipManage'], function (): void {
        Route::get('/', [App\Http\Controllers\ShipManage\ShipRegController::class, 'index']);
        Route::get('shipinfo', [App\Http\Controllers\ShipManage\ShipRegController::class, 'loadShipGeneralInfos']);
        Route::get('registerShipData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'registerShipData']);
        Route::post('deleteShipData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'deleteShipData']);
        Route::post('loadShipTypePage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'loadShipTypePage']);
        Route::post('shipDataTabPage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipDataTabPage']);
        Route::post('loadShipTypeData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'loadShipTypeData']);
        Route::post('loadShipTypeModifyPage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'loadShipTypeModifyPage']);
        Route::post('saveShipData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipData']);
        Route::post('saveShipGeneralData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipGeneralData']);
        Route::post('saveShipHullData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipHullData']);
        Route::post('saveShipMachineryData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipMachineryData']);
        Route::post('saveShipRemarksData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipRemarksData']);
        Route::post('saveShipSafetyData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipSafetyData']);
        Route::post('deleteShipSafetyData', [App\Http\Controllers\ShipManage\ShipRegController::class, 'deleteShipSafetyData']);
        Route::get('dynamicList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'dynamicList']);
        Route::get('ctm/analytics', [App\Http\Controllers\ShipManage\ShipRegController::class, 'ctmAnalytics']);

        Route::get('voy/evaluation', [App\Http\Controllers\ShipManage\ShipRegController::class, 'voyEvaluation']);

        Route::get('shipMaterialList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipMaterialList']);
        Route::post('shipMaterialType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipMaterialType']);
        Route::post('shipMaterialCategory', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipMaterialCategory']);
        Route::post('shipMaterialList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipMaterialList']);
        Route::get('shipMaterialManage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipMaterialManage']);

        Route::get('shipCertList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipCertList']);
        Route::get('shipCertExcel', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipCertExcel']);
        Route::post('shipCertList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipCertList']);
        Route::post('shipCertType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipCertType']);
        Route::post('getShipCertInfo', [App\Http\Controllers\ShipManage\ShipRegController::class, 'getShipCertInfo']);
        Route::post('updateCertInfo', [App\Http\Controllers\ShipManage\ShipRegController::class, 'updateCertInfo']);
        Route::post('deleteShipCert', [App\Http\Controllers\ShipManage\ShipRegController::class, 'deleteShipCert']);
        Route::get('shipCertManage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipCertManage']);
        Route::post('getCertType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'getCertType']);
        Route::post('updateCertType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'updateCertType']);
        Route::post('deleteShipCertType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'deleteShipCertType']);
        Route::get('shipEquipmentManage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipEquipmentManage']);
        Route::get('fuelManage', [App\Http\Controllers\ShipManage\ShipRegController::class, 'fuelManage']);
        Route::post('fuelSave', [App\Http\Controllers\ShipManage\ShipRegController::class, 'fuelSave']);
        Route::get('equipment', [App\Http\Controllers\ShipManage\ShipRegController::class, 'shipEquipmentManage']);
        Route::post('shipEquipmentList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipEquipList']);

        Route::post('shipReqEquipmentList', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipReqEquipList']);
        Route::post('saveShipReqEquipmentType', [App\Http\Controllers\ShipManage\ShipRegController::class, 'saveShipReqEquipType']);
        Route::get('exportShipInfo', [App\Http\Controllers\ShipManage\ShipRegController::class, 'exportShipInfo']);
    });

    Route::group(['prefix' => 'shipMember'], function (): void {
        Route::get('/', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'index']);
        Route::get('shipMember', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'loadShipMembers']);
        Route::get('registerShipMember', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'registerShipMember']);
        Route::post('showShipMemberDataTab', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'showShipMemberDataTab']);
        Route::post('updateMemberInfo', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'updateMemberInfo']);
        Route::post('updateMemberMainInfo', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'updateMemberMainInfo']);
        Route::post('updateMemberMainData', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'updateMemberMainData']);
        Route::post('updateMemberCapacityData', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'updateMemberCapacityData']);
        Route::post('updateMemberTrainingData', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'updateMemberTrainingData']);
        Route::post('registerMemberExamingData', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'registerMemberExamingData']);
        Route::post('deleteShipMember', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'deleteShipMember']);
        Route::get('totalShipMember', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'totalShipMember'])->name('shipmember.list');
        Route::get('memberCertList', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'memberCertList']);
        Route::get('integretedMemberExaming', [App\Http\Controllers\ShipManage\ShipMemberController::class, 'integretedMemberExaming']);
        Route::get('wagesCalc', [App\Http\Controllers\ShipManage\WageController::class, 'index'])->name('wages.calc');
        Route::get('wagesSend', [App\Http\Controllers\ShipManage\WageController::class, 'send'])->name('wages.send');
        Route::get('wagesCalcReport', [App\Http\Controllers\ShipManage\WageController::class, 'index_report'])->name('wages.calc.report');
        Route::get('wagesSendReport', [App\Http\Controllers\ShipManage\WageController::class, 'send_report'])->name('wages.send.report');
        Route::get('wagesList', [App\Http\Controllers\ShipManage\WageController::class, 'wagelist']);
        Route::post('updateWageCalcInfo', [App\Http\Controllers\ShipManage\WageController::class, 'updateWageCalcInfo']);
        Route::post('updateWageSendInfo', [App\Http\Controllers\ShipManage\WageController::class, 'updateWageSendInfo']);
    });

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    //# RepairController
    Route::get('/repair/register', [App\Http\Controllers\RepairController::class, 'register'])->name('repair.register');
    Route::post('/repair/update', [App\Http\Controllers\RepairController::class, 'update'])->name('repair.update');
    Route::post('ajax/repair/list', [App\Http\Controllers\RepairController::class, 'ajax_list']);
    Route::post('ajax/repair/delete', [App\Http\Controllers\RepairController::class, 'ajax_delete']);

    Route::get('/repair/list', [App\Http\Controllers\RepairController::class, 'list'])->name('repiare.list');
    Route::post('ajax/repair/report', [App\Http\Controllers\RepairController::class, 'ajax_getReport']);
    Route::post('ajax/repair/search', [App\Http\Controllers\RepairController::class, 'ajax_search']);

    Route::get('voy/register', [App\Http\Controllers\Business\BusinessController::class, 'voyRegister'])->name('voy.register');
    Route::post('voy/update', [App\Http\Controllers\Business\BusinessController::class, 'voyUpdate'])->name('voy.update');
    Route::post('ajax/voy/detail', [App\Http\Controllers\Business\BusinessController::class, 'ajax_voyDetail']);
});

Route::get('test/git/pull', [App\Http\Controllers\TestController::class, 'gitPull'])->name('git.pull');
