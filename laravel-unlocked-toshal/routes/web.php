<?php

if (App::environment('production')) {
    URL::forceScheme('https');
}
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
Route::middleware('XssSanitizer')->group(function (): void {
    Auth::routes();
    Route::get('/', 'Frontend\SiteController@index')->name('home');
    // Route::get('/', 'Admin\AdminDashboardController@login');
    Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');
    Route::get('auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');

    //facebook login routes
    Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFacebook');
    Route::get('auth/facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');

    Route::get('logout', 'Admin\AdminDashboardController@logout')->name('logout');
    // Route::get('/home', 'Admin\AdminDashboardController@index')->name('home');
});
// Frontend  routes
Route::namespace('Frontend')->group(function (): void {
    Route::get('/register', 'RegistrationController@registerUser')->name('register');
    Route::post('/register', 'RegistrationController@registerUser')->name('register');
    Route::get('verify/email/{token}', 'RegistrationController@verifyEmail')->name('verifyEmail');
    Route::get('reset-password', 'UserController@password_reset')->name('password.reset');
    Route::post('reset-password-email', 'UserController@password_reset_link')->name('passwordreset');
    Route::get('reset-password/check/token/{token}', 'UserController@password_reset_token_check')->name('checktoken');
    Route::post('update-new-password', 'UserController@update_new_password')->name('userupdatenewpassword');
    Route::get('set-new-password', 'UserController@new_password_set')->name('usersetnewpassword');
    // Route::get('/show_venue', 'SiteController@getvenues');
    Route::get('/show_venue/{keyword?}', 'SiteController@getvenues');
    Route::post('/show_cat_venue', 'SiteController@getCategoryVenue')->name('show_cat_venue');
    Route::get('/show_all_cat_venue/{id}', 'SiteController@getAllVenue')->name('showallcatvenue');
    Route::post('/category_venue', 'SiteController@getFilterVenue')->name('category_venue');
    Route::get('/venue-detail/{id}', 'SiteController@venue_detail')->name('venuedetail');
    Route::get('/book-venue', 'SiteController@book_venue')->name('bookvenue');
    Route::post('/user-booking', 'BookingController@booking')->name('booking_user');
    Route::post('/contactus/user', 'SiteController@contactUs')->name('contact_us');

    //Rating Routes
    Route::get('rating/add', 'RatingController@add_form')->name('rating.add');
    Route::post('rating/create', 'RatingController@add_record')->name('rating.create');
    Route::get('venue/add', 'UserController@add_form')->name('venue.add');
    Route::post('venue/insert', 'UserController@insert_record')->name('venue.insert');
    Route::get('blog/listing', 'BlogController@getList')->name('blog.listing');
});

Route::namespace('Frontend')->prefix('user')->middleware('XssSanitizer', 'user', 'prevent-back-history')->group(function (): void {
    Route::get('dashboard', 'UserController@index')->name('userdashboard');
    Route::get('detail/update', 'UserController@edit_form')->name('detail.update');
    Route::post('details/update', 'UserController@update_record')->name('update.details');
    Route::get('profile-photo/remove', 'UserController@remove_photo')->name('profilephoto.remove');
    Route::get('change/password', 'UserController@edit_password')->name('change.password');
    Route::post('password/update', 'UserController@update_password')->name('update.password');

    // Booking Routes
    Route::get('bookings/list', 'BookingController@getList')->name('bookings.mybookings');
    Route::get('bookings/details/{id}', 'BookingController@view_detail')->name('bookings.booking_detail');
    Route::get('bookings/details/{id}', 'BookingController@view_detail')->name('bookings.booking_detail');
    Route::get('booking/cancel', 'BookingController@booking_cancel')->name('booking.cancels');
});
//Owner routes
Route::namespace('Frontend')->prefix('owner')->middleware('XssSanitizer', 'owner', 'prevent-back-history')->group(function (): void {
    Route::get('dashboard', 'OwnerController@index')->name('ownerdashboard');
});

// Admin panel routes

Route::namespace('Admin')->prefix('admin')->group(function (): void {
    Route::get('/', 'AdminDashboardController@login')->name('admin');
    Route::post('login/check', 'AdminDashboardController@login_check')->name('login.check');
    Route::get('reset-password', 'AdminDashboardController@password_reset')->name('resetpassword');
    Route::post('reset-password-email', 'AdminDashboardController@password_reset_link')->name('sendpasswordemail');
    Route::get('reset-password/check/token/{token}', 'AdminDashboardController@password_reset_token_check')->name('tokencheck');
    Route::get('set-new-password', 'AdminDashboardController@new_password_set')->name('setnewpassword');
    Route::post('update-new-password', 'AdminDashboardController@update_new_password')->name('updatenewpassword');
});
Route::namespace('Admin')->prefix('admin')->middleware('admin', 'prevent-back-history')->group(function (): void {
    Route::get('dashboard', 'AdminDashboardController@index')->name('admindashboard');
    Route::post('details/update', 'AdminDashboardController@update_record')->name('details.update');
    Route::post('password/update', 'AdminDashboardController@update_password')->name('password.update');
    Route::post('search', 'SearchController@getSearchedData');

    //Manage Users Routes

    Route::get('users/list', 'UserManageController@getList')->name('users.list');
    Route::get('user/status/update', 'UserManageController@change_status')->name('user.status');
    Route::get('user/verify/update', 'UserManageController@verifyUser')->name('user.verify');
    Route::get('user/add', 'UserManageController@add_form')->name('user.add');
    Route::post('user/create', 'UserManageController@create_record')->name('user.create');
    Route::get('user/edit/{id}', 'UserManageController@edit_form')->name('user.edit');
    Route::post('user/update', 'UserManageController@update_record')->name('user.update');
    Route::get('user/changepassword/{id}', 'UserManageController@change_password')->name('user.changepassword');
    Route::post('user/updatepassword', 'UserManageController@update_password')->name('user.updatepassword');
    Route::get('user/delete', 'UserManageController@del_record')->name('user.delete');
    Route::get('user/details/{id}', 'UserManageController@view_detail')->name('user.details');
    Route::get('user/csv', 'ExportController@exportUser')->name('exportuser');

    // Manage Owners Routes
    Route::get('owners/list', 'OwnerManageController@getList')->name('owners.list');
    Route::get('owner/add', 'OwnerManageController@add_form')->name('owner.add');
    Route::post('owner/create', 'OwnerManageController@add_record')->name('owner.create');

    Route::get('owner/delete', 'OwnerManageController@del_record')->name('owner.delete');
    Route::get('owner/edit/{id}', 'OwnerManageController@edit_form')->name('owner.edit');
    Route::post('owner/update', 'OwnerManageController@update_record')->name('owner.update');
    Route::get('owner/changepassword/{id}', 'OwnerManageController@change_password')->name('owner.changepassword');
    Route::post('owner/updatepassword', 'OwnerManageController@update_password')->name('owner.updatepassword');
    Route::get('owner/status/update', 'OwnerManageController@change_status')->name('owner.status');
    Route::get('owner/details/{id}', 'OwnerManageController@view_detail')->name('owner.details');
    Route::get('owner/confirm', 'OwnerManageController@confirm_request')->name('owner.confirm');
    Route::get('owner/csv', 'ExportController@exportOwner')->name('exportowner');

    // Venue Routes
    Route::get('venues/list', 'VenueController@getList')->name('venues.list');
    Route::get('venue/status/update', 'VenueController@change_status')->name('venue.status');
    Route::get('venue/delete', 'VenueController@deleteRecord')->name('venue.delete');
    Route::get('venue/edit/{id}', 'VenueController@edit_form')->name('venue.edit');
    Route::post('venue/update', 'VenueController@update_record')->name('venue.update');
    Route::get('venue/add', 'VenueController@add_form')->name('venue.add');
    Route::post('venue/create', 'VenueController@add_record')->name('venue.create');
    Route::get('venue/details/{id}', 'VenueController@view_detail')->name('venue.details');
    Route::get('venue/csv', 'ExportController@exportVenue')->name('exportvenue');

    // Booking Routes
    Route::get('bookings/list', 'BookingController@getList')->name('bookings.list');
    Route::get('booking/add', 'BookingController@add_form')->name('booking.add');
    Route::post('booking/create', 'BookingController@add_record')->name('booking.create');
    Route::get('booking/confirm', 'BookingController@confirm_request')->name('booking.confirm');
    Route::get('booking/edit/{id}', 'BookingController@edit_form')->name('booking.edit');
    Route::post('booking/update', 'BookingController@update_record')->name('booking.update');
    Route::get('booking/delete/{id}', 'BookingController@del_record')->name('booking.delete');
    Route::get('booking/details/{id}', 'BookingController@view_detail')->name('booking.details');
    Route::get('booking/csv', 'ExportController@exportBooking')->name('exportbooking');

    //Category & Subcategory Routes
    Route::get('categories/list', 'CategoryController@getList')->name('categories.list');
    Route::get('category/add', 'CategoryController@add_form')->name('category.add');
    Route::post('category/create', 'CategoryController@add_record')->name('category.create');
    Route::get('category/status/update', 'CategoryController@change_status')->name('category.status');
    Route::get('category/edit/{id}', 'CategoryController@edit_form')->name('category.edit');
    Route::post('category/update', 'CategoryController@update_record')->name('category.update');
    Route::get('category/delete', 'CategoryController@del_record')->name('category.delete');

    //Blog Routes
    Route::get('blogs/list', 'BlogController@getList')->name('blogs.list');
    Route::get('blog/add', 'BlogController@add_form')->name('blog.add');
    Route::post('blog/create', 'BlogController@add_record')->name('blog.create');
    Route::get('blog/edit/{id}', 'BlogController@edit_form')->name('blog.edit');
    Route::get('blog/status/update', 'BlogController@change_status')->name('blog.status');
    Route::post('blog/update', 'BlogController@update_record')->name('blog.update');
    Route::get('blog/delete/{id}', 'BlogController@del_record')->name('blog.delete');

    //Commission Routes
    Route::get('commission/add', 'CommissionController@add_form')->name('commission.add');
    Route::post('commission/create', 'CommissionController@add_record')->name('commission.create');
    Route::get('commission/owner_commission/{id}', 'CommissionController@calculate_commission')->name('commission.ownercommission');
    Route::get('commission/csv', 'ExportController@exportCommission')->name('exportcommission');
    Route::get('earning/csv', 'ExportController@exportEarning')->name('exportearning');

    //Rating & Review Routes
    Route::get('ratings/list', 'RatingController@getList')->name('ratings.list');
    Route::get('rating/status/update', 'RatingController@change_status')->name('rating.status');

    // CMS Page Routes

    Route::get('cms-pages/list', 'CmsPageController@getList')->name('cms-pages.list');
    Route::get('cms-pages/add', 'CmsPageController@add_form')->name('cms-pages.add');
    Route::post('cms-pages/create', 'CmsPageController@create_record')->name('cms-pages.create');
    Route::get('cms-pages/edit/{id}', 'CmsPageController@edit_form')->name('cms-pages.edit');
    Route::post('cms-pages/update', 'CmsPageController@update_record')->name('cms-pages.update');
    Route::get('cms-pages/status/update', 'CmsPageController@change_status')->name('cms-pages.status');
    Route::get('cms-pages/delete/{id}', 'CmsPageController@del_record')->name('cms-pages.delete');
    Route::get('cms-pages/show/{id}', 'CmsPageController@show')->name('cms-pages.show');

    //Testimonials Routes

    Route::get('testimonial/list', 'TestimonialController@getList')->name('testimonial.list');
    Route::get('testimonial/add', 'TestimonialController@add_form')->name('testimonial.add');
    Route::post('testimonial/create', 'TestimonialController@create_record')->name('testimonial.create');
    Route::get('testimonial/edit/{id}', 'TestimonialController@edit_form')->name('testimonial.edit');
    Route::post('testimonial/update', 'TestimonialController@update_record')->name('testimonial.update');
    Route::get('testimonial/delete/{id}', 'TestimonialController@del_record')->name('testimonial.delete');
    Route::get('testimonial/status/update', 'TestimonialController@change_status')->name('testimonial.status');

    //Permission Routes

    Route::get('permissions/list', 'PermissionController@getList')->name('permission.list');
    Route::get('permission/add', 'PermissionController@add_form')->name('permission.add');
    Route::post('permission/create', 'PermissionController@create_record')->name('permission.create');
    Route::get('permission/edit/{id}', 'PermissionController@edit_form')->name('permission.edit');
    Route::post('permission/update', 'PermissionController@update_record')->name('permission.update');
    Route::get('permission/delete/{id}', 'PermissionController@del_record')->name('permission.delete');

    //Role Routes

    Route::get('roles/list', 'RoleController@getList')->name('roles.list');
    Route::get('role/add', 'RoleController@add_form')->name('role.add');
    Route::post('role/create', 'RoleController@create_record')->name('role.create');
    Route::get('role/edit/{id}', 'RoleController@edit_form')->name('role.edit');
    Route::post('role/update', 'RoleController@update_record')->name('role.update');
    Route::get('role/delete/{id}', 'RoleController@del_record')->name('role.delete');

    //SMTP Routes

    Route::get('smtp/list', 'SmtpDetailsController@getList')->name('smtp.list');
    Route::get('smtp/edit/{id}', 'SmtpDetailsController@edit_form')->name('smtp.edit');
    Route::post('smtp/update', 'SmtpDetailsController@update_record')->name('smtp.update');

    //Auto responder template  Routes

    Route::get('autoresponder/list', 'AutoResponderController@getList')->name('autoresponder.list');
    Route::get('autoresponder/template/edit/{id}', 'AutoResponderController@edit_form')->name('autoresponder.edit');
    Route::post('autoresponder/template/update', 'AutoResponderController@update_record')->name('autoresponder.update');
});
