<?php

use App\Http\Controllers\AuthenticationLoginPageController;
use App\Http\Controllers\AuthenticationRegisterPageController;

use App\Http\Controllers\HomePageController;

use App\Http\Controllers\CartMyPageController;

use App\Http\Controllers\CategoryManagePageController;
use App\Http\Controllers\CategoryUpdatePageController;

use App\Http\Controllers\HeaderComponentController;

use App\Http\Controllers\KeyboardAddPageController;
use App\Http\Controllers\KeyboardDetailPageController;
use App\Http\Controllers\KeyboardUpdatePageController;
use App\Http\Controllers\KeyboardViewPageController;

use App\Http\Controllers\TransactionHistoryPageController;
use App\Http\Controllers\TransactionHistoryDetailPageController;

use App\Http\Controllers\UserChangePasswordPageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
    return Redirect::to('/login');
});

Route::prefix('/login')->name('login.')->group(function () {
    Route::get('/', [AuthenticationLoginPageController::class, 'index'])->name('index');
    Route::prefix('/api')->name('api.')->group(function () {
        Route::post('/authentication/login', [AuthenticationLoginPageController::class, 'login'])->name('login');
    });
});

Route::prefix('/register')->name('register.')->group(function () {
    Route::get('/', [AuthenticationRegisterPageController::class, 'index'])->name('index');
    Route::prefix('/api')->name('api.')->group(function () {
        Route::post('/authentication/register', [AuthenticationRegisterPageController::class, 'register'])->name('register');
    });
});


// customer ---------------------------------------------------

// route for customer pages with prefix and names
Route::prefix('/customer')->name('customer.')->group(function () {
    // route for home pages with prefix and names
    Route::prefix('/home')->name('home.')->group(function () {
        Route::get('/', [HomePageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/categories', [HomePageController::class, 'readAllCategory'])->name('readAllCategory');
        });
    });

    // route for my cart pages with prefix and names
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartMyPageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/keyboards/{id}', [CartMyPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
            Route::get('/keyboards/{id}', [CartMyPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
            Route::get('/cartKeyboars/{id}', [CartMyPageController::class, 'readOneCartKeyboardById'])->name('readOneCartKeyboardById');
            Route::put('/cartKeyboards/{id}', [CartMyPageController::class, 'updateOneCartKeyboardById'])->name('updateOneCartKeyboardById');
            Route::delete('/cartKeyboards/{id}', [CartMyPageController::class, 'deleteOneCartKeyboardById'])->name('deleteOneCartKeyboardById');
            Route::get('/cartKeyboards/users/{id}', [CartMyPageController::class, 'readAllCartKeyboardByUserId'])->name('readAllCartKeyboardByUserId');
        });
    });

    // route for header component with prefix and names
    Route::prefix('/header')->name('header.')->group(function () {
        Route::get('/', [HeaderComponentController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/users/{id}', [HeaderComponentController::class, 'readOneUserById'])->name('readOneUserById');
        });
    });

    // route for keyboard pages with prefix and names
    Route::prefix('/keyboard')->name('keyboard.')->group(function () {
        Route::get('/', [KeyboardViewPageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/categories', [KeyboardViewPageController::class, 'readAllCategory'])->name('readAllCategory');
            Route::get('/categories/{id}', [KeyboardViewPageController::class, 'readOneCategoryById'])->name('readOneCategoryById');
            Route::get('/keyboards', [KeyboardViewPageController::class, 'readAllKeyboard'])->name('readAllKeyboard');
            Route::get('/keyboards/{id}', [KeyboardViewPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
            Route::delete('/keyboards/{id}', [KeyboardViewPageController::class, 'deleteOneKeyboardById'])->name('deleteOneKeyboardById');
        });

        // route for keyboard add page with prefix and names
        Route::prefix('/add')->name('add.')->group(function () {
            Route::get('/', [KeyboardAddPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::post('/keyboards', [KeyboardAddPageController::class, 'addKeyboard'])->name('addKeyboard');
            });
        });

        // route for keyboard detail page with prefix and names
        Route::prefix('/detail')->name('detail.')->group(function () {
            Route::get('/{id}', [KeyboardDetailPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/keyboards/{id}', [KeyboardDetailPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
                Route::post('/cartKeyboards/', [KeyboardDetailPageController::class, 'createOneCartKeyboard'])->name('createOneCartKeyboard');
            });
        });

        // route for keyboard update page with prefix and names
        Route::prefix('/update')->name('update.')->group(function () {
            Route::get('/{id}', [KeyboardUpdatePageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/keyboards/id', [KeyboardUpdatePageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
                Route::put('/keyboards/{id}', [KeyboardUpdatePageController::class, 'updateOneKeyboardById'])->name('updateOneKeyboardById');
            });
        });
    });

    // route for transaction history pages with prefix and names
    Route::prefix('/transaction')->name('transaction.')->group(function () {
        Route::get('/', [TransactionHistoryPageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/transactionKeyboards', [TransactionHistoryPageController::class, 'readAllTransactionKeyboard'])->name('readAllTransactionKeyboard');
            Route::get('/transactionKeyboards/users/{id}', [TransactionHistoryPageController::class, 'readAllTransactionKeyboardByUserId'])->name('readAllTransactionKeyboardByUserId');
            Route::get('/transactionKeyboards/{id}', [TransactionHistoryPageController::class, 'readOneTransactionKeyboardById'])->name('readOneTransactionKeyboardById');
            Route::get('/keyboards/{id}', [TransactionHistoryPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
        });

        // route for transaction history detail page with prefix and names
        Route::prefix('/detail')->name('detail.')->group(function () {
            Route::get('/{id}', [TransactionHistoryDetailPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/keyboards/{id}', [TransactionHistoryDetailPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
                Route::get('/transactionKeyboards/{id}', [TransactionHistoryDetailPageController::class, 'readOneTransactionKeyboardById'])->name('readOneTransactionKeyboardById');
            });
        });
    });

    // route for change password pages with prefix and names
    Route::prefix('/change-password')->name('change-password.')->group(function () {
        Route::get('/', [UserChangePasswordPageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::post('/users/{id}', [UserChangePasswordPageController::class, 'readOneUserById'])->name('readOneUserById');
            Route::post('/users/{id}/changePassword', [UserChangePasswordPageController::class, 'changeUserPasswordById'])->name('changeUserPasswordById');
        });
    });
});

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
