<?php
Route::get('/', 'HomePageController@index');
Route::get('search', 'HomePageController@table')->name('search');
Route::get('apps/{app}', 'HomePageController@app')->name('app');
Route::get('mods/{mod}', 'HomePageController@mod')->name('mod');

Route::redirect('/home', '/admin');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // apps
    Route::delete('apps/destroy', 'AppsController@massDestroy')->name('apps.massDestroy');
    Route::resource('apps', 'AppsController');

    // Mods
    Route::delete('mods/destroy', 'ModsController@massDestroy')->name('mods.massDestroy');
    Route::post('mods/media', 'ModsController@storeMedia')->name('mods.storeMedia');
    Route::resource('mods', 'ModsController');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
