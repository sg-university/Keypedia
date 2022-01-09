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
        $userId = request()->userId;
        $cartKeyboardId = request()->cartKeyboardId;

        $userCartKeyboards = $this->readAllCartKeyboardByUserId($userId);
        $cartKeyboard =  $this->readOneCartKeyboardById($cartKeyboardId);
        $keyboard = $this->readOneKeyboardById($cartKeyboard['data']->keyboard_id);
        $data = [
            'userCartKeboards' => $userCartKeyboards,
            'cartKeyboard' => $cartKeyboard,
            'keyboard' => $keyboard,
        ];
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readKeyboardById($id);
    }


    public function readAllCartKeyboard()
    {
        return $this->cartController->readAllCartKeyboard();
    }

    public function readAllCartKeyboardByUserId($userId)
    {
        $carts = $this->cartController->readAllCart();
        $userCarts = $carts['data']->where('user_id', $userId);
        $userCartKeyboards = $userCarts->keyboards;
        return $userCartKeyboards;
    }

    public function readOneCartKeyboardById($id)
    {
        return $this->cartController->readOneCartKeyboardById($id);
    }

    public function updateOneCartKeyboardById($id, $cartKeyboardToUpdate)
    {
        return $this->cartController->updateOneCartKeyboardById($id, $cartKeyboardToUpdate);
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
