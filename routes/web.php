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

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

// customer ---------------------------------------------------
Route::get('/customer/index', function () {
    return view('/customer/index');
});

Route::get('/customer/historydetail', function () {
    return view('/customer/historydetail');
});

Route::get('/customer/history', function () {
    return view('/customer/history');
});

Route::get('/customer/detail', function () {
    return view('/customer/detail');
});

Route::get('/customer/view', function () {
    return view('/customer/view');
});

Route::get('/customer/detail', function () {
    return view('/customer/detail');
});

Route::get('/customer/cart', function () {
    return view('/customer/cart');
});


Route::get('/customer/password', function () {
    return view('/customer/password');
});

// manager -----------------------------------------------------

Route::get('/templates/menuhome', function () {
    return view('/templates/menuhome');
});

Route::get('/manager/manage', function () {
    return view('/manager/manage');
});

Route::get('/manager/update', function () {
    return view('/manager/update');
});

Route::get('/manager/detail', function () {
    return view('/manager/detail');
});

Route::get('/manager/index', function () {
    return view('/manager/index');
});

Route::get('/manager/add', function () {
    return view('/manager/add');
});

Route::get('/manager/updateCategory', function () {
    return view('/manager/updateCategory');
});

Route::get('/manager/password', function () {
    return view('/manager/password');
});

Route::get('/manager/view', function () {
    return view('/manager/view');
});

Route::get('/manager/add', function () {
    return view('/manager/add');
});

Route::get('/manager/detail', function () {
    return view('/manager/detail');
});

// guest -----------------------------------------------------

Route::get('/guest/index', function () {
    return view('/guest/index');
});

Route::get('/guest/view', function () {
    return view('/guest/view');
});

Route::get('/guest/detail', function () {
    return view('/guest/detail');
});

Route::get('/guest/detail', function () {
    return view('/guest/detail');
});