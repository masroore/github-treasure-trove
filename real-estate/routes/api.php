<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Crm Status
    Route::apiResource('crm-statuses', 'CrmStatusApiController');

    // Crm Customer
    Route::apiResource('crm-customers', 'CrmCustomerApiController');

    // Crm Note
    Route::apiResource('crm-notes', 'CrmNoteApiController');

    // Crm Document
    Route::post('crm-documents/media', 'CrmDocumentApiController@storeMedia')->name('crm-documents.storeMedia');
    Route::apiResource('crm-documents', 'CrmDocumentApiController');

    // Category
    Route::apiResource('categories', 'CategoryApiController');

    // Property
    Route::post('properties/media', 'PropertyApiController@storeMedia')->name('properties.storeMedia');
    Route::apiResource('properties', 'PropertyApiController');

    // Amenities
    Route::apiResource('amenities', 'AmenitiesApiController');

    // Propoerty Inquiries
    Route::apiResource('propoerty-inquiries', 'PropoertyInquiriesApiController');

    // Property Reviews
    Route::post('property-reviews/media', 'PropertyReviewsApiController@storeMedia')->name('property-reviews.storeMedia');
    Route::apiResource('property-reviews', 'PropertyReviewsApiController');

    // About Us
    Route::post('aboutuses/media', 'AboutUsApiController@storeMedia')->name('aboutuses.storeMedia');
    Route::apiResource('aboutuses', 'AboutUsApiController');

    // Faq
    Route::apiResource('faqs', 'FaqApiController');

    // Contact Us Messages
    Route::apiResource('contact-us-messages', 'ContactUsMessagesApiController');

    // Seaches
    Route::apiResource('seaches', 'SeachesApiController');

    // Subscribers
    Route::apiResource('subscribers', 'SubscribersApiController');
});
