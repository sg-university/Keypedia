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
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TransactionHistoryPageController;
use App\Http\Controllers\TransactionHistoryDetailPageController;

use App\Http\Controllers\UserChangePasswordPageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;

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
    return RouteController::rolesMainRedirection();
});

Route::prefix('/authentication')->name('authentication.')->group(function () {
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
            Route::get('/keyboards', [CartMyPageController::class, 'readAllCartKeyboard'])->name('readAllCartKeyboard');
            Route::get('/keyboards/{id}', [CartMyPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
            Route::get('/cartKeyboars/{id}', [CartMyPageController::class, 'readOneCartKeyboardById'])->name('readOneCartKeyboardById');
            Route::put('/cartKeyboards/{id}', [CartMyPageController::class, 'updateOneCartKeyboardById'])->name('updateOneCartKeyboardById');
            Route::delete('/cartKeyboards/{id}', [CartMyPageController::class, 'deleteOneCartKeyboardById'])->name('deleteOneCartKeyboardById');
            Route::get('/cartKeyboards/users/{id}', [CartMyPageController::class, 'readAllCartKeyboardByUserId'])->name('readAllCartKeyboardByUserId');
            Route::get('/cartKeyboards/checkout/users/{id}', [CartMyPageController::class, 'checkoutCartByUserId'])->name('checkoutCartByUserId');
        });
    });

    // route for header component with prefix and names
    Route::prefix('/header')->name('header.')->group(function () {
        Route::get('/', [HeaderComponentController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/users/{id}', [HeaderComponentController::class, 'readOneUserById'])->name('readOneUserById');
            Route::get('/authentication/logout', [HeaderComponentController::class, 'logout'])->name('logout');
            Route::get('/categories', [HeaderComponentController::class, 'readAllCategory'])->name('readAllCategory');
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
            Route::post('/keyboards/search', [KeyboardViewPageController::class, 'searchAllKeyboardByKeywords'])->name('searchAllKeyboardByKeywords');
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
            Route::get('/transactions', [TransactionHistoryPageController::class, 'readAllTransactionKeyboard'])->name('readAllTransactionKeyboard');
            Route::get('/transactions/users/{id}', [TransactionHistoryPageController::class, 'readAllTransactionByUserId'])->name('readAllTransactionByUserId');
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
            Route::put('/users/{id}/changePassword', [UserChangePasswordPageController::class, 'changeUserPasswordById'])->name('changeUserPasswordById');
        });
    });
});

// manager -----------------------------------------------------

// route for manager pages with prefix and names
Route::prefix('/manager')->name('manager.')->group(function () {
    // route for home pages with prefix and names
    Route::prefix('/home')->name('home.')->group(function () {
        Route::get('/', [HomePageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/categories', [HomePageController::class, 'readAllCategory'])->name('readAllCategory');
        });
    });

    // route for category pages with prefix and names
    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/', [CategoryManagePageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/categories', [CategoryManagePageController::class, 'readAllCategory'])->name('readAllCategory');
            Route::delete('/categories/{id}', [CategoryManagePageController::class, 'deleteOneCategoryById'])->name('deleteOneCategoryById');
        });

        // route for category update page with prefix and names
        Route::prefix('/update')->name('update.')->group(function () {
            Route::get('/{id}', [CategoryUpdatePageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/categories/{id}', [CategoryUpdatePageController::class, 'readOneCategoryById'])->name('readOneCategoryById');
                Route::put('/categories/{id}', [CategoryUpdatePageController::class, 'updateOneCategoryById'])->name('updateOneCategoryById');
            });
        });
    });

    // route for header component with prefix and names
    Route::prefix('/header')->name('header.')->group(function () {
        Route::get('/', [HeaderComponentController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/users/{id}', [HeaderComponentController::class, 'readOneUserById'])->name('readOneUserById');
            Route::get('/authentication/logout', [HeaderComponentController::class, 'logout'])->name('logout');
            Route::get('/categories', [HeaderComponentController::class, 'readAllCategory'])->name('readAllCategory');
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
            Route::post('/keyboards/search', [KeyboardViewPageController::class, 'searchAllKeyboardByKeywords'])->name('searchAllKeyboardByKeywords');
        });

        // route for keyboard add page with prefix and names
        Route::prefix('/add')->name('add.')->group(function () {
            Route::get('/', [KeyboardAddPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::post('/keyboards', [KeyboardAddPageController::class, 'createOneKeyboard'])->name('createOneKeyboard');
            });
        });

        // route for keyboard detail page with prefix and names
        Route::prefix('/detail')->name('detail.')->group(function () {
            Route::get('/{id}', [KeyboardDetailPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/keyboards/{id}', [KeyboardDetailPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
                Route::post('/cartKeyboards', [KeyboardDetailPageController::class, 'createOneCartKeyboard'])->name('createOneCartKeyboard');
                Route::put('/keyboards/{id}', [KeyboardDetailPageController::class, 'updateOneKeyboardById'])->name('updateOneKeyboardById');
                Route::delete('/keyboards/{id}', [KeyboardDetailPageController::class, 'deleteOneKeyboardById'])->name('deleteOneKeyboardById');
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

    // route for change password pages with prefix and names
    Route::prefix('/change-password')->name('change-password.')->group(function () {
        Route::get('/', [UserChangePasswordPageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::post('/users/{id}', [UserChangePasswordPageController::class, 'readOneUserById'])->name('readOneUserById');
            Route::put('/users/{id}/changePassword', [UserChangePasswordPageController::class, 'changeUserPasswordById'])->name('changeUserPasswordById');
        });
    });
});

// guest -----------------------------------------------------

// route for guest pages with prefix and names
Route::prefix('/guest')->name('guest.')->group(function () {
    // route for home pages with prefix and names
    Route::prefix('/home')->name('home.')->group(function () {
        Route::get('/', [HomePageController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/categories', [HomePageController::class, 'readAllCategory'])->name('readAllCategory');
        });
    });

    // route for header component with prefix and names
    Route::prefix('/header')->name('header.')->group(function () {
        Route::get('/', [HeaderComponentController::class, 'index'])->name('index');
        Route::prefix('/api')->name('api.')->group(function () {
            Route::get('/users/{id}', [HeaderComponentController::class, 'readOneUserById'])->name('readOneUserById');
            Route::get('/authentication/logout', [HeaderComponentController::class, 'logout'])->name('logout');
            Route::get('/categories', [HeaderComponentController::class, 'readAllCategory'])->name('readAllCategory');
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
            Route::post('/keyboards/search', [KeyboardViewPageController::class, 'searchAllKeyboardByKeywords'])->name('searchAllKeyboardByKeywords');
        });

        // route for keyboard detail page with prefix and names
        Route::prefix('/detail')->name('detail.')->group(function () {
            Route::get('/{id}', [KeyboardDetailPageController::class, 'index'])->name('index');
            Route::prefix('/api')->name('api.')->group(function () {
                Route::get('/keyboards/{id}', [KeyboardDetailPageController::class, 'readOneKeyboardById'])->name('readOneKeyboardById');
                Route::post('/cartKeyboards/', [KeyboardDetailPageController::class, 'createOneCartKeyboard'])->name('createOneCartKeyboard');
            });
        });
    });
});
