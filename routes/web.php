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

Route::middleware('auth')->group(function () {
    Route::get('/', 'Frontend\PageController@index')->name('home');
    Route::get('/account', 'Frontend\PageController@account')->name('account');
    Route::get('/update-password', 'Frontend\PageController@editPassword')->name('update-password');
    Route::patch('/update-password', 'Frontend\PageController@updatePassword');
    Route::get('/wallet', 'Frontend\PageController@wallet')->name('wallet');
    Route::get('/transfer', 'Frontend\PageController@transfer')->name('transfer');

    Route::post('/transfer', 'Frontend\PageController@transferProcess');
    Route::post('/transfer-confirmation', 'Frontend\PageController@transferConfirmation')->name('transfer-confirmation');
    Route::post('/check-user', 'Frontend\PageController@checkUser')->name('check-user');
    Route::post('/check-password', 'Frontend\PageController@checkPassword')->name('check-password');

    Route::get('/qr-code', 'Frontend\PageController@qrCode')->name('qr-code');
    Route::get('/scan', 'Frontend\PageController@scan')->name('scan');
    Route::get('/transaction', 'Frontend\PageController@transaction')->name('transaction');

});

Auth::routes();

Route::prefix('admin')->group(function () {

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');

});
