<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class KeyboardAddPageController extends Controller
{
    public $keyboardController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
    }

    public function index()
    {
        $data = [];
        return view('', $data);
    }

    public function createOneKeyboard($keyboardToCreate)
    {
        return $this->keyboardController->createOneKeyboard($keyboardToCreate);
    }

    // test all method in this controller
    public function test()
    {
    }
}
