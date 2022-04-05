<?php

// Route::redirect('/', '/login');
Route::get('/', 'HomepageController@index')->name('home.page');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('property/{id}', 'HomepageController@property')->name('property.name');
Route::post('property/store-inquiry', 'HomepageController@storeInquiry')->name('property.enquiry');
Route::post('property/create-review', 'HomepageController@createPropertyReview')->name('property.review');
Route::get('properties', 'HomepageController@allProperties')->name('all.properties');
Route::get('about-us', 'HomepageController@aboutUs')->name('about.us');
Route::get('blogs', 'HomepageController@allBlogs')->name('all.blogs');
Route::get('contact-us', 'HomepageController@contactUs')->name('contact.us');
Route::post('search', 'HomepageController@search')->name('search');

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'app', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function (): void {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Crm Status
    Route::delete('crm-statuses/destroy', 'CrmStatusController@massDestroy')->name('crm-statuses.massDestroy');
    Route::resource('crm-statuses', 'CrmStatusController');

    // Crm Customer
    Route::delete('crm-customers/destroy', 'CrmCustomerController@massDestroy')->name('crm-customers.massDestroy');
    Route::resource('crm-customers', 'CrmCustomerController');

    // Crm Note
    Route::delete('crm-notes/destroy', 'CrmNoteController@massDestroy')->name('crm-notes.massDestroy');
    Route::resource('crm-notes', 'CrmNoteController');

    // Crm Document
    Route::delete('crm-documents/destroy', 'CrmDocumentController@massDestroy')->name('crm-documents.massDestroy');
    Route::post('crm-documents/media', 'CrmDocumentController@storeMedia')->name('crm-documents.storeMedia');
    Route::post('crm-documents/ckmedia', 'CrmDocumentController@storeCKEditorImages')->name('crm-documents.storeCKEditorImages');
    Route::resource('crm-documents', 'CrmDocumentController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoryController');

    // Property
    Route::delete('properties/destroy', 'PropertyController@massDestroy')->name('properties.massDestroy');
    Route::post('properties/media', 'PropertyController@storeMedia')->name('properties.storeMedia');
    Route::post('properties/ckmedia', 'PropertyController@storeCKEditorImages')->name('properties.storeCKEditorImages');
    Route::resource('properties', 'PropertyController');
    Route::get('properties/send/message', 'PropertyController@sendMessage')->name('property.send-message');

    // Messages
    Route::delete('messages/destroy', 'MessagesController@massDestroy')->name('messages.massDestroy');
    Route::resource('messages', 'MessagesController');

    // Amenities
    Route::delete('amenities/destroy', 'AmenitiesController@massDestroy')->name('amenities.massDestroy');
    Route::resource('amenities', 'AmenitiesController');

    // Property Tags
    Route::delete('property-tags/destroy', 'PropertyTagsController@massDestroy')->name('property-tags.massDestroy');
    Route::resource('property-tags', 'PropertyTagsController');

    // Propoerty Inquiries
    Route::delete('propoerty-inquiries/destroy', 'PropoertyInquiriesController@massDestroy')->name('propoerty-inquiries.massDestroy');
    Route::resource('propoerty-inquiries', 'PropoertyInquiriesController');

    // Property Reviews
    Route::delete('property-reviews/destroy', 'PropertyReviewsController@massDestroy')->name('property-reviews.massDestroy');
    Route::post('property-reviews/media', 'PropertyReviewsController@storeMedia')->name('property-reviews.storeMedia');
    Route::post('property-reviews/ckmedia', 'PropertyReviewsController@storeCKEditorImages')->name('property-reviews.storeCKEditorImages');
    Route::resource('property-reviews', 'PropertyReviewsController');

    // About Us
    Route::delete('aboutuses/destroy', 'AboutUsController@massDestroy')->name('aboutuses.massDestroy');
    Route::post('aboutuses/media', 'AboutUsController@storeMedia')->name('aboutuses.storeMedia');
    Route::post('aboutuses/ckmedia', 'AboutUsController@storeCKEditorImages')->name('aboutuses.storeCKEditorImages');
    Route::resource('aboutuses', 'AboutUsController');

    // Faq
    Route::delete('faqs/destroy', 'FaqController@massDestroy')->name('faqs.massDestroy');
    Route::resource('faqs', 'FaqController');

    // Contact Us Messages
    Route::delete('contact-us-messages/destroy', 'ContactUsMessagesController@massDestroy')->name('contact-us-messages.massDestroy');
    Route::resource('contact-us-messages', 'ContactUsMessagesController');

    // Blog
    Route::delete('blogs/destroy', 'BlogController@massDestroy')->name('blogs.massDestroy');
    Route::post('blogs/media', 'BlogController@storeMedia')->name('blogs.storeMedia');
    Route::post('blogs/ckmedia', 'BlogController@storeCKEditorImages')->name('blogs.storeCKEditorImages');
    Route::resource('blogs', 'BlogController');

    // Seaches
    Route::delete('seaches/destroy', 'SeachesController@massDestroy')->name('seaches.massDestroy');
    Route::resource('seaches', 'SeachesController');

    // Our Partners
    Route::delete('our-partners/destroy', 'OurPartnersController@massDestroy')->name('our-partners.massDestroy');
    Route::post('our-partners/media', 'OurPartnersController@storeMedia')->name('our-partners.storeMedia');
    Route::post('our-partners/ckmedia', 'OurPartnersController@storeCKEditorImages')->name('our-partners.storeCKEditorImages');
    Route::resource('our-partners', 'OurPartnersController');

    // Subscribers
    Route::delete('subscribers/destroy', 'SubscribersController@massDestroy')->name('subscribers.massDestroy');
    Route::resource('subscribers', 'SubscribersController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function (): void {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
