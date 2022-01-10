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
    public $keyboardController, $categoryController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
        $this->categoryController = new CategoryController();
    }

    public function index($id)
    {
        $categoriesResult =  $this->readAllCategory();
        $categories = $categoriesResult['data'];
        $keyboardResult =  $this->readOneKeyboardById($id);
        $keyboard = $keyboardResult['data'];
        $data = ['keyboard' => $keyboard, 'categories' => $categories];
        return RouteController::view('update', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readOneKeyboardById($id);
    }

    public function updateOneKeyboardById($id, Request $request)
    {
        $keyboardToUpdate = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $request->image,
        ];

        $keyboardResult = $this->keyboardController->updateOneKeyboardById($id, $keyboardToUpdate);

        switch ($keyboardResult['message']) {
            case $this->keyboardController->MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALID:
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
