<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartKeyboard;
use App\Models\Keyboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartMyPageController extends Controller
{
    private $cartController, $keyboardController;

    public function __construct()
    {
        $this->cartController = new CartController();
        $this->keyboardController = new KeyboardController();
    }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $userCartKeyboards = $this->readAllCartKeyboardByUserId($userId);
        $data = [
            'user' => $user,
            'userCartKeyboards' => $userCartKeyboards,
        ];
        return RouteController::view('cart', $data);
    }

    public function checkoutCartByUserId($id)
    {
        $userCartKeyboardsResult = $this->cartController->checkoutCartByUserId($id);
        if ($userCartKeyboardsResult['message'] != $this->cartController->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALID) {
            return redirect()->back()->withErrors($userCartKeyboardsResult['data'])->withInput();
        }

        return redirect()->back()->with($userCartKeyboardsResult);
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readKeyboardById($id);
    }


    public function readAllCartKeyboard()
    {
        return $this->cartController->readAllCartKeyboard();
    }

    public function readAllCartKeyboardByUserId($id)
    {
        $carts = $this->cartController->readAllCart();
        $userCarts = $carts['data']->where('user_id', $id)->first();
        $userCartKeyboards = $userCarts->keyboards;
        return $userCartKeyboards;
    }

    public function readOneCartKeyboardById($id)
    {
        return $this->cartController->readOneCartKeyboardById($id);
    }

    public function updateOneCartKeyboardById($id, Request $request)
    {
        $cartKeyboardToUpdate = [
            'quantity' => $request->quantity,
            'keyboard_id' => $request->keyboard_id,
        ];

        $cartKeyboardResult = $this->cartController->updateOneCartKeyboardById($id, $cartKeyboardToUpdate);

        switch ($cartKeyboardResult['message']) {
            case $this->cartController->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALID:
                return redirect()->back()->with($cartKeyboardResult);
                break;
            case $this->cartController->MESSAGE_CHECKOUT_CART_BY_USER_ID_INVALID:
                return redirect()->back()->withErrors([$cartKeyboardResult['message']])->withInput();
                break;
            default:
                return redirect()->back()->withErrors($cartKeyboardResult['data'])->withInput();
                break;
        }
    }

    public function deleteOneCartKeyboardById($id)
    {
        return $this->cartController->deleteOneCartKeyboardById($id);
    }

    // test all method in this controller
    public function test()
    {
    }
}
