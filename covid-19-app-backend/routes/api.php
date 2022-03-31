<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    // Device
    Route::post('devices', 'DeviceApiController@save');
    Route::post('positif', 'DeviceApiController@positif');
});
