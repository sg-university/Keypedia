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
    private $cartController;

    public function __construct()
    {
        $this->cartController = new CartController();
    }

    public function readAllCartKeyboard()
    {
        return $this->readAllCartKeyboard();
    }

    public function readOneCartKeyboardById($id)
    {
        return $this->readOneCartKeyboardById($id);
    }

    public function updateOneCartKeyboardById($id, $cartKeyboardToUpdate)
    {
        return $this->updateOneCartKeyboardById($id, $cartKeyboardToUpdate);
    }

    public function deleteOneCartKeyboardById($id)
    {
        return $this->deleteOneCartKeyboardById($id);
    }

    // test all method in this controller
    public function test()
    {
    }
}
