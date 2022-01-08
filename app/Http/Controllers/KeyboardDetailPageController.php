<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class KeyboardDetailPageController extends Controller
{
    public $keyboardController, $cartController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
        $this->cartController = new CartController();
    }

    public function index()
    {
        $data = [];
        return view('', $data);
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readOneKeyboardById($id);
    }

    public function createOneCartKeyboard($keyboardToCreate)
    {
        return $this->cartController->createOneCartKeyboard($keyboardToCreate);
    }

    // test all method in this controller
    public function test()
    {
    }
}
