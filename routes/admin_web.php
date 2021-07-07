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

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('logout', 'Auth\AdminLoginController@logout');

    Route::delete('users/delete-selected', 'Backend\UserController@deleteSelected');
    Route::resource('users', 'Backend\UserController')->except(['show']);
    Route::get('users/database/ssd', 'Backend\UserController@ssd');

    Route::delete('admin-users/delete-selected', 'Backend\AdminUserController@deleteSelected');
    Route::resource('admin-users', 'Backend\AdminUserController')->except(['show']);
    Route::get('admin-users/database/ssd', 'Backend\AdminUserController@ssd');

    Route::delete('wallets/delete-selected', 'Backend\WalletController@deleteSelected');
    Route::get('wallets/database/ssd', 'Backend\WalletController@ssd');
    Route::resource('wallets', 'Backend\WalletController')->except(['show']);

});
