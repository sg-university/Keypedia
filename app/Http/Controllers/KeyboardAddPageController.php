<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Illuminate\Support\Str;

class KeyboardAddPageController extends Controller
{
    public $keyboardController, $categoryController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
        $this->categoryController = new CategoryController();
    }

    public function index()
    {
        $categoriesResult =  $this->readAllCategory();
        $categories = $categoriesResult['data'];
        $data = ['categories' => $categories];
        return RouteController::view('add', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }


    public function createOneKeyboard(Request $request)
    {
        $keyboardToCreate = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $request->image,
        ];

        $keyboardResult = $this->keyboardController->createOneKeyboard($keyboardToCreate);

        switch ($keyboardResult['message']) {
            case $this->keyboardController->MESSAGE_CREATE_ONE_KEYBOARD_VALID:
                return redirect()->back()->with($keyboardResult);
                break;
            default:
                return redirect()->back()->withErrors($keyboardResult['data'])->withInput();
                break;
        }
    }

    // test all method in this controller
    public function test()
    {
    }
}
