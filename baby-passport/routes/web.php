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

Route::get('sitemap', 'WebController@getSitemap');

Route::get('guiapartoenusa', 'WebController@getGuiapartoenusa');

Route::get('/mama/contacto', 'WebController@getContactForm')->name('web.getContactForm');
Route::post('/mama/contacto', 'WebController@postContactForm')->name('web.postContactForm');

Route::get('/', 'WebController@getIndex')->name('web.index');
Route::get('/mama/proceso', 'WebController@getMom')->name('web.mom');
Route::get('/ciudades/{city}', 'WebController@cityPage')->name('web.cityPage');
Route::get('/mama/registro', 'WebController@getRegisterMom')->name('web.getRegisterMom');

Route::get('/hospital/{slug}', 'HospitalController@getHospital')->name('web.getHospital');
Route::get('/hospital/{slug}/setAppointment/{user_id}/{cart_id}', 'HospitalController@getSetAppointment')->name('web.getSetAppointment');

Route::get('/doctores', 'WebController@getSearchDoctores')->name('web.searchDoctores');
Route::get('/soy-doctor', 'WebController@getDoctor')->name('web.doctor');
Route::get('/soy-doctor/suscripcion', 'WebController@getDoctorSubscription')->name('web.doctorSubscription');
Route::post('/soy-doctor/suscripcion', 'WebController@postDoctorSubscription')->name('web.postDoctorSubscription');
Route::get('/doctor/registro', 'WebController@getRegisterDoctor')->name('web.getRegisterDoctor');

//BLOG
Route::get('/blog', 'BlogController@getBlog')->name('web.getBlog');
Route::get('/blog/busqueda', 'BlogController@getBlogByQuery')->name('web.getBlogByQuery');
Route::get('/blog/etiquetas/{slug}', 'BlogController@getBlogByTag')->name('web.getBlogByTag');
Route::get('/blog/categorias/{slug}', 'BlogController@getBlogBycategory')->name('web.getBlogByCategory');
Route::get('/blog/{slug}', 'BlogController@getDetailBlog')->name('web.getDetailBlog');

//Nav
Route::get('/nosotros', 'WebController@getAboutUs')->name('web.getAboutUs');
Route::get('/como-ganar', 'WebController@getHowToWin')->name('web.getHowToWin');
Route::get('/centros-atencion', 'WebController@getAtentionCenter')->name('web.getAtentionCenter');
Route::get('/contratacion', 'WebController@getBooking')->name('web.getBooking');
Route::get('/terminos-condiciones', 'WebController@getTerms')->name('web.getTerms');
Route::get('/politicas-privacidad', 'WebController@getPolicies')->name('web.getPolicies');
Route::get('/preguntas-frecuentes', 'WebController@getFaqs')->name('web.getFaqs');

//atention-centers
Route::get('/centros-atencion-city/{city}', 'WebController@getAtentionCenterCity')->name('web.centerAtention');

Route::get('/payments/generateReceipt/{cart_id}', 'PaymentController@generatePurchaseReceipt');

Auth::routes();

Route::middleware(['auth'])->group(function (): void {
    Route::get('/notifications', 'NotificationController@getNotifications')->name('notifications.fetch');
    Route::get('/notifications/{id}/delete', 'NotificationController@markAsRead')->name('notifications.markAsRead');

    //MOM PANEL
    Route::get('/mama/{id}', 'MomProfileController@getMomProfile')->name('web.getMomProfile');
    Route::post('/mama/changePhoto/{user_id}', 'MomProfileController@changePhoto')->name('web.changePhoto');
    Route::post('/mama/uploadVoucher/{cart_id}', 'MomProfileController@uploadVoucher')->name('web.uploadVoucher');
    Route::post('/mama/saveProfile/{user_id}', 'MomProfileController@postUpdateProfile')->name('web.postMomProfile');
    Route::get('/mom/setMaternityPackage/{hospital_product_id}', 'MomProfileController@setMaternityPackage')->name('web.setMaternityPackage');
    Route::post('/mama/savePreregister/{user_id}', 'MomHistoryController@postSavePreregister')->name('web.postSavePreregister');

    //PAYMENT ACTIONS
    Route::post('/downloadBankReference', 'PaymentController@downloadBankReference')->name('web.downloadBankReference');
    Route::get('/generateReceipt/{cart_payment_id}', 'PaymentController@generateReceipt')->name('web.generateReceipt');
    Route::post('/payWithPaypal', 'PaymentController@payWithPaypal')->name('web.postPayWithPaypal');
    Route::get('/savePaypalPurchase', 'PaymentController@savePaypalPurchase')->name('web.savePaypalPurchase');
    Route::post('/cancelPaypal', 'PaymentController@cancelPaypal')->name('web.cancelPaypal');
    Route::post('/payWithOpenPay', 'PaymentController@payWithOpenPay')->name('web.postOpenPay');
    Route::get('/payment/{cart_payment_id}/printReceipt', 'PaymentController@printPayment')->name('web.printPayment');
    Route::get('/paymentHistory/{cart_id}', 'PaymentController@getPaymentHistory')->name('web.getPaymentHistory');

    //ADMIN PANEL
    Route::prefix('tags')->group(function (): void {
        Route::get('', 'TagController@index')->name('tags.index');
        Route::post('', 'TagController@store')->name('tags.store');
        Route::patch('/{id}', 'TagController@update')->name('tags.update');
        Route::get('setStatus/{id}/{status}', 'TagController@setStatus')->name('tags.setStatus');
    });

    Route::prefix('ratings')->group(function (): void {
        Route::get('', 'RatingController@index')->name('ratings.index');
        Route::post('', 'RatingController@store')->name('ratings.store');
        Route::patch('/{id}', 'RatingController@update')->name('ratings.update');
        Route::get('setStatus/{id}/{status}', 'RatingController@setStatus')->name('ratings.setStatus');
    });

    Route::prefix('categories')->group(function (): void {
        Route::get('', 'CategoryController@index')->name('categories.index');
        Route::post('', 'CategoryController@store')->name('categories.store');
        Route::patch('/{id}', 'CategoryController@update')->name('categories.update');
        Route::get('setStatus/{id}/{status}', 'CategoryController@setStatus')->name('categories.setStatus');
    });

    Route::prefix('cities')->group(function (): void {
        Route::get('', 'CityController@index')->name('cities.index');
        Route::get('/listHospitals/{id}', 'CityController@listHospitals')->name('cities.listHospitals');
        Route::post('', 'CityController@store')->name('cities.store');
        Route::patch('/{id}', 'CityController@update')->name('cities.update');
        Route::post('/{id}/deleteImage/{type}', 'CityController@deleteImage')->name('cities.deleteImage');
        Route::get('setStatus/{id}/{status}', 'CityController@setStatus')->name('cities.setStatus');
    });

    Route::prefix('hospitals')->group(function (): void {
        Route::get('', 'HospitalController@index')->name('hospitals.index');
        Route::get('/listProducts/{id}', 'HospitalController@listProducts')->name('hospitals.listProducts');
        Route::post('', 'HospitalController@store')->name('hospitals.store');
        Route::get('/{id}', 'HospitalController@edit')->name('hospitals.edit');
        Route::patch('/{id}', 'HospitalController@update')->name('hospitals.update');
        Route::post('{id}/setAppointment', 'HospitalController@postSetAppointment')->name('web.postSetAppointment');
        Route::get('setStatus/{id}/{status}', 'HospitalController@setStatus')->name('hospitals.setStatus');
    });

    Route::prefix('products')->group(function (): void {
        Route::get('', 'ProductController@index')->name('products.index');
        Route::post('', 'ProductController@store')->name('products.store');
        Route::get('/{id}', 'ProductController@edit')->name('products.edit');
        Route::patch('/{id}', 'ProductController@update')->name('products.update');
        Route::get('detail/{id}/delete', 'ProductController@deleteDetail')->name('products.deleteDetail');
    });

    Route::prefix('blogs')->group(function (): void {
        Route::get('', 'BlogController@index')->name('blogs.index');
        Route::get('/create/{id?}', 'BlogController@create')->name('blogs.create');
        Route::post('', 'BlogController@store')->name('blogs.store');
        Route::get('/{id}', 'BlogController@edit')->name('blogs.edit');
        Route::post('/{id}', 'BlogController@update')->name('blogs.update');
        Route::delete('/deleteTopic/{topic_id}', 'BlogController@deleteTopic')->name('blogs.deleteTopic');
        Route::post('/deleteImage/{id}/{type}', 'BlogController@deleteImage')->name('blogs.deleteImage');
    });

    Route::prefix('ads')->group(function (): void {
        Route::get('', 'AdvertisingController@index')->name('ads.index');
        Route::get('/create/{id?}', 'AdvertisingController@create')->name('ads.create');
        Route::post('', 'AdvertisingController@store')->name('ads.store');
        Route::post('/{id}', 'AdvertisingController@update')->name('ads.update');
        Route::post('/deleteImage/{id}', 'AdvertisingController@deleteImage')->name('ads.deleteImage');
    });

    Route::prefix('users')->group(function (): void {
        Route::get('', 'UserController@index')->name('users.index');
        Route::get('/{id}/viewProfile', 'UserController@viewProfile')->name('users.profile');
    });
});
