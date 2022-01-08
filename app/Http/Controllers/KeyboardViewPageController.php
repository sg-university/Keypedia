<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class KeyboardViewPageController extends Controller
{
    public $keyboardController, $categoryController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
        $this->categoryController = new CategoryController();
    }

    public function index()
    {
        $data = [];
        return view('', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }

    public function readOneCategoryById($id)
    {
        return $this->categoryController->readOneCategoryById($id);
    }

    public function readAllKeyboard()
    {
        return $this->keyboardController->readAllKeyboard();
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readOneKeyboardById($id);
    }

    public function deleteOneKeyboardById($id)
    {
        return $this->keyboardController->deleteOneKeyboardById($id);
    }

    // test all method in this controller
    public function test()
    {
    }
}
