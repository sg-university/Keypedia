<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class KeyboardUpdatePageController extends Controller
{
    public $keyboardController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
    }

    public function index()
    {
        $categryId = request()->keyboardId;
        $data = ['keyboard' => $this->readOneKeyboardById($categryId)];
        return view('', $data);
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readOneKeyboardById($id);
    }

    public function updateOneKeyboardById($id, $keyboardToUpdate)
    {
        return $this->keyboardController->updateOneKeyboardById($id, $keyboardToUpdate);
    }

    // test all method in this controller
    public function test()
    {
    }
}
