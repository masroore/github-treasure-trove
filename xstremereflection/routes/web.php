<?php

//resources//
Route::resources([
    'invoice' => 'InvoiceController',

]);

//Home //

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);
//EndHome//

//Company Routes //

Route::get('/company/leads', 'CompanyController@leads');
Route::get('/company/estimates', 'CompanyController@estimates');
Route::get('/company/workorders', 'CompanyController@workorders');
Route::get('/company/invoices', 'CompanyController@invoices');

Route::get('/packageList', function () {
    $packageTypes = \Vanguard\PackageType::get();
    $packages = \Vanguard\Package::where('companyId', 0)->orWhere('companyId', 1)->get();

    return view('home.allpackage', compact('packages', 'packageTypes'));
});

//Email Templates//

Route::get('/estimateapproved/{id}', 'EmailTemplateController@estimateApproved');

//Package Ajax//

Route::get('/packageData/{id}', function ($id) {
    $package = Vanguard\Package::find($id);

    return $package->toJson();
});

/**
 * Authentication.
 */
Route::get('login', 'Auth\LoginController@show');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['registration', 'guest']], function (): void {
    Route::get('register', 'Auth\RegisterController@show');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function (): void {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication.
 */
Route::group(['middleware' => 'two-factor'], function (): void {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login.
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::group(['middleware' => ['auth', 'verified']], function (): void {

    /**
     * Impersonate Routes.
     */
    Route::impersonate();

    /**
     * Dashboard.
     */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard/manage', 'DashboardController@manage')->name('dashboard.manage');
    Route::get('/leads', function (): void {
        \Vanguard\Estimate::where('companyId', Auth()->user()->companyId)
           ->whereNull('dateofService')->get();
    });

    /**
     * Company Routes.
     */
    Route::get('/company', 'CompanyController@index');
    Route::get('/company/{id}', 'CompanyController@show');
    /**
     * User Profile.
     */
    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function (): void {
        Route::get('/', 'ProfileController@show')->name('profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });

    /**
     * Two-Factor Authentication Setup.
     */
    Route::group(['middleware' => 'two-factor'], function (): void {
        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

        Route::get('two-factor/verification', 'TwoFactorController@verification')
            ->name('two-factor.verification')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/resend', 'TwoFactorController@resend')
            ->name('two-factor.resend')
            ->middleware('throttle:1,1', 'verify-2fa-phone');

        Route::post('two-factor/verify', 'TwoFactorController@verify')
            ->name('two-factor.verify')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
    });

    /**
     * User Management.
     */
    Route::resource('users', 'Users\UsersController')
        ->except('update')->middleware('permission:users.manage');

    Route::group(['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'], function (): void {
        Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
        Route::put('update/login-details', 'Users\LoginDetailsController@update')
            ->name('users.update.login-details');

        Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
        Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
            ->name('user.update.avatar.external');

        Route::get('sessions', 'Users\SessionsController@index')
            ->name('user.sessions')->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
            ->name('user.sessions.invalidate')->middleware('session.database');

        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');
    });

    Route::get('markAllRead', function () {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    })->name('markAllRead');

    /**
     * Roles & Permissions.
     */
    Route::group(['namespace' => 'Authorization'], function (): void {
        Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

        Route::post('permissions/save', 'RolePermissionsController@update')
            ->name('permissions.save')
            ->middleware('permission:permissions.manage');

        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
    });

    /**
     * Settings.
     */
    Route::get('settings', 'SettingsController@general')->name('settings.general')
        ->middleware('permission:settings.general');

    Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
        ->middleware('permission:settings.general');

    Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
        ->middleware('permission:settings.auth');

    if (config('services.authy.key')) {
        Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
            ->name('settings.auth.2fa.enable')
            ->middleware('permission:settings.auth');

        Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
            ->name('settings.auth.2fa.disable')
            ->middleware('permission:settings.auth');
    }

    Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
        ->name('settings.registration.captcha.enable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
        ->name('settings.registration.captcha.disable')
        ->middleware('permission:settings.auth');

    Route::get('settings/notifications', 'SettingsController@notifications')
        ->name('settings.notifications')
        ->middleware('permission:settings.notifications');

    Route::post('settings/notifications', 'SettingsController@update')
        ->name('settings.notifications.update')
        ->middleware('permission:settings.notifications');

    /**
     * Activity Log.
     */
    Route::get('activity', 'ActivityController@index')->name('activity.index')
        ->middleware('permission:users.activity');

    Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
        ->middleware('permission:users.activity');
});

    /**
     * Packages.
     */
    Route::get('packages', 'PackageController@index')->name('packages');
    Route::get('packages/create', 'PackageController@create');
    Route::post('package/store', 'PackageController@store');
    Route::get('package/edit/{id}', 'PackageController@edit');
    Route::put('package/store/{id}', 'PackageController@update');
    Route::get('/package/{id}', 'PackageController@show')->name('package.show');

/**
 * Square API Routes.
 */
// Basic charge
Route::get('/charge', 'ChargeController@charge');

Route::group(['prefix' => 'merchant'], function (): void {
    // Charge with merchant
    Route::get('/{merchant}/charge', 'ChargeController@chargeWithMerchant');
    // Charge with merchant and customer
    Route::get('/{merchant}/customer/{customer}/charge', 'ChargeController@chargeWithMerchantAndCustomer');
});

Route::group(['prefix' => 'customer'], function (): void {
    // Create customer
    Route::get('/create', 'ChargeController@createCustomer');
    // Charge with customer
    Route::get('/{customer}/charge', 'ChargeController@chargeWithCustomer');
});

Route::group(['prefix' => 'order'], function (): void {
    // Create an order
    Route::get('/', 'OrderController@order');
    // Order with merchant
    Route::get('/{merchant}/merchant', 'OrderController@orderWithMerchant');
    // Order with customer
    Route::get('/{customer}/customer', 'OrderController@orderWithCustomer');
    // Order with customer and merchant included
    Route::get('/{merchant}/{customer}', 'OrderController@orderWithCustomerAndMerchant');
});

    /**
     * Service Routes.
     */
    Route::get('/service', 'ServicesController@index');

    /**
     * Package Routes.
     */
    Route::post('/package/storeService/{id}', 'PackageController@addService');
    Route::get('/package/serviceItemRemove/{id}', 'PackageController@removeService');
    Route::post('/package/storeIncludedPackage/{id}', 'PackageController@addIncludedPackage');
    Route::get('/package/packageIncludeRemove/{rid}/{id}', 'PackageController@removePackageInclude');
    Route::post('/package/storeUpsale/{id}', 'PackageController@addUpdsale');

    /**
     *Estimates.
     */
    Route::get('/estimate/void/{id}', 'EstimateController@voidEstimate');
    Route::post('estimate/store', 'EstimateController@store');
    Route::get('/customer/form', 'CustomerController@customerForm');
    Route::get('/customer/edit/form/{eid}', 'EstimateController@customerEditForm');
    Route::post('/estimate/{id}/edit', 'EstimateController@customerEdit');
    Route::get('/estimate/{id}/show', 'EstimateController@show')->name('estimate.show');
    Route::post('/estimate/{id}/addPackage', 'EstimateController@addPackage');
    Route::post('/estimate/addVehicle/{cid}/{eid}', 'EstimateController@addVehicle');
    Route::get('/estimate/workOrder/{id}', 'EstimateController@estimateMakeWorkOrder');
    Route::get('/estimate', 'EstimateController@index')->name('estimates');
    Route::get('/estimate/mail/{id}', 'EstimateController@estimateEmail');
    Route::get('/removePackage/{id}', 'EstimateController@destroyPackage');
    Route::get('/modal/estimateupdate/{id}', 'EstimateController@estimateRescheduleModal');
    Route::get('/modal/workorderupdate/{id}', 'WorkOrderController@updateModal');
    Route::get('/estimate/cancel/{id}', 'EstimateController@estimateCancel');
    Route::post('/estimate/updatedate/{id}', 'EstimateController@updateDate');
    Route::get('/estimate/reschedulemail/{id}', 'EstimateController@rescheduleEmail');
    Route::get('/estimate/completed', 'EstimateController@approved');
    Route::get('/estimate/canceled', 'EstimateController@canceled');
    Route::get('/upsale/{id}/pdf', 'EstimateController@upsalePdf');
    Route::get('/estimate/package/{id}', 'EstimateController@upsaleRecommendationModal');
    Route::get('/estimate/clearselectedpackage/{id}', 'EstimateController@clearSelectedPackage');
    Route::get('/estimate/next', 'EstimateController@nextServiceEmail');
    Route::post('//addwarrantycode/{id}', 'EstimateController@addWarrantyCode');
    Route::get('/modal/packageServices/{id}', function ($id) {
        $package = \Vanguard\EstimatePackage::find($id);

        return view('estimate.partials.modalBodyServices', compact('package', 'id'));
    });

use GuzzleHttp\Client;

    Route::get('estimate/selectpackage/{eid}/{id}', function ($eid, $id) {
        $package = \Vanguard\EstimatePackage::find($id);

        $estimate = \Vanguard\Estimate::find($eid);
        $estimate->total = $package->chargedPrice;
        $estimate->deposit = $package->deposit;
        $estimate->approvedPackage = $id;
        $estimate->save();

        return back()->with('success', 'Customer problem description updated.');
    });
use Illuminate\Http\Request;

    Route::get('/sms/send', function (): void {
        $estimate = \Vanguard\Estimate::get();
        foreach ($estimate as $row) {
            $row->customerCode = Str::random(10);
            $row->save();
        }
    });

    Route::post('/estimate/note/{id}', function (Request $request, $id) {
        $tracking = new \Vanguard\EstimateTracking();
        $tracking->estimateId = $id;
        $tracking->note = $request->note;
        $tracking->save();

        return back()->with('success', 'New note has been added.');
    });
    Route::post('/updateProblem/{id}', function (Request $request, $id) {
        $estimate = \Vanguard\Estimate::find($id);
        $estimate->problem = $request->problem;
        $estimate->save();

        return back()->with('success', 'Estimate customer description updated.');
    });
    Route::get('estimate/{id}/pdf', 'EstimateController@pdf');
    Route::post('/estimate/package/addservice/{id}', 'EstimateController@addPackageService');

    Route::get('/estimate/customerReview/{id}', 'EstimateController@customerReview');
    Route::get('/modal/updatePackage/{id}', function ($id) {
        $package = \Vanguard\EstimatePackage::find($id);
        //dd($package);
        return view('estimate.partials.updatePackageModalBody', compact('package'));
    });
    Route::post('/updatePackage/{id}', function (Request $request, $id) {
        $package = \Vanguard\EstimatePackage::find($id);
        $package->chargedPrice = $request->chargedPrice;
        $package->save();

        return back()->with('success', 'Package has been updated.');
    });

    Route::get('customerSignatureBody/{pid}/{eid}', function ($pid, $eid) {
        $package = \Vanguard\EstimatePackage::find($pid);
        $estimate = \Vanguard\Estimate::find($eid);

        return view('estimate.partials.modalCustomerSignatureBody', compact('pid', 'eid', 'package', 'estimate'));
    });
    Route::post('customerSignature/{pid}/{eid}', 'EstimateController@uploadSignature');

    /**
     * Work Orders.
     */
    Route::get('workorder/{id}/show', 'WorkOrderController@show')->name('workorder.show');
    Route::get('workorder/techenroute/{id}', 'WorkOrderController@techEnroute');
    Route::get('/workorder/addServices/{id}', 'WorkOrderController@addServices');
    Route::get('/workorder/serviceComplete/{id}', 'WorkOrderController@serviceComplete');

    ROUTE::get('email', function () {
        $title = 'Test';
        $content = 'Content';

        return view('emails.estimate', compact('title', 'content'));
    });

    ROUTE::get('/wo', function (): void {
        $wo = Vanguard\WorkOrder::get();

        foreach ($wo as $row) {
            $e = Vanguard\Estimate::find($row->estimateId);

            $row->totalCharge = $e->total;
            $row->save();
        }
    });
Route::post('/updateVehicle/{id}', 'WorkOrderController@updateVehicle');
Route::get('/workorder', 'WorkOrderController@index');
Route::get('/workorder/canceled', 'WorkOrderController@canceled');
Route::get('/workorder/completed/{id}', 'WorkOrderController@completed');
Route::get('/workorder/completed', 'WorkOrderController@completedWo');

/**
 * Payment Routes.
 */
Route::post('/payment/{id}/{type}', 'PaymentController@paymentProcess');

    /**
     * Calander.
     */
    Route::get('/ical/{cid}', 'IcalController@getEventsICalObject');

    /**
     * Invoices.
     */
    Route::get('/estimate/invoice/{id}', 'InvoiceController@estimateConvert');
    Route::get('/invoice/{id}', 'InvoiceController@show');
    Route::get('/invoice/{id}/create', 'InvoiceController@store');
    Route::get('/invoice/{id}/paymentModal', 'InvoiceController@paymentModal');
    Route::post('/invoice/payment/{id}', 'InvoiceController@payment');

    Route::get('/testmessage', function (): void {
        \Nexmo\Laravel\Facade\Nexmo::message()->send([
            'to' => '17408215531',
            'from' => '17408215531',
            'text' => 'This is a test message',
        ]);
    });

use Illuminate\Support\Str;

Route::get('/vin-api/{vin}', function ($vin) {
    //dd($vin);
    $headers = [
        'Content-Type' => 'application/json',
        'x-rapidapi-host' => 'vindecoder.p.rapidapi.com',
        'x-rapidapi-key' => '6797e8dda6msh238d7561690a0e3p1c0cb0jsn907db54b4db9',
    ];
    $params = [
        'Content-Type' => 'application/json',
        'vin' => $vin,

    ];

    $client = new Client([
        'headers' => $headers,
        'query' => $params,
    ]);

    $response = $client->request('GET', 'https://vindecoder.p.rapidapi.com/decode_vin');
    //dd($response);
    $statusCode = $response->getStatusCode();
    $body = $response->getBody()->getContents();

    //dd($body);

    return $body;
});

    /**
     * Inspection.
     */
    Route::get('/inspection/{eid}/{vid}', 'InspectionController@show');

/**
 * Installation.
 */
Route::group(['prefix' => 'install'], function (): void {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});
