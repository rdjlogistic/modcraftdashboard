<?php
Route::get('/', 'HomePageController@index');
// Route::get('/', 'LoginController@index');
// Route::post('/login/verify', 'LoginController@verify');
// Route::get('/logout', 'LoginController@logout');

// Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'index']);
// Route::post('/login/verify', [App\Http\Controllers\Auth\LoginController::class, 'verify'])->name('remember-me.login-verify');
// Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Route::get('/dashboard', 'HomePageController@index')->name('dashboard');

Route::get('search', 'HomePageController@table')->name('search');
Route::get('apps/{app}', 'HomePageController@app')->name('app');
Route::get('mods/{mod}', 'HomePageController@mod')->name('mod');
Route::get('maps/{map}', 'HomePageController@map')->name('map');
Route::get('skins/{skin}', 'HomePageController@skin')->name('skin');

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

    // Maps
    Route::delete('maps/destroy', 'MapsController@massDestroy')->name('maps.massDestroy');
    Route::post('maps/media', 'MapsController@storeMedia')->name('maps.storeMedia');
    Route::resource('maps', 'MapsController');

    // Skins
    Route::delete('skins/destroy', 'SkinsController@massDestroy')->name('skins.massDestroy');
    Route::post('skins/media', 'SkinsController@storeMedia')->name('skins.storeMedia');
    Route::resource('skins', 'SkinsController');

  
    
});

Route::group(['prefix' => 'v1/api/', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('mods', 'ModsController@getModsByApp');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



