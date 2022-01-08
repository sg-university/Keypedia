<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KeyboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\RegisterPageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function (Request $request) {
    $response = ['message' => 'passed', 'data' => null];
    try {
        $authenticationController = new AuthenticationController();
        $authenticationController->test();

        $userController = new UserController();
        $userController->test();

        $categoryController = new CategoryController();
        $categoryController->test();

        $keyboardController = new KeyboardController();
        $keyboardController->test();

        $cartController = new CartController();
        $cartController->test();

        $transactionController = new TransactionController();
        $transactionController->test();
    } catch (Throwable $th) {
        $response = ['message' => 'failed', 'data' => $th];
    }

    dd($response);
});
