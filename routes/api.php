<?php

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1\Admin', 'middleware' => ['api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');
    
    // Users
    // Route::get('mods/{app_id}', 'ModsApiController@getModsByApp');

    Route::get('mods', 'ModsApiController@getModsByApp');

    Route::get('maps', 'MapsApiController@getMapsByApp');

    Route::get('skins', 'SkinsApiController@getSkinsByApp');


});

