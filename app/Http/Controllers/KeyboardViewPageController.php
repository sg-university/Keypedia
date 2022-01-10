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

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $categoryResult = $this->categoryController->readOneCategoryById($categoryId);
        $category = $categoryResult['data'];
        $keyboardsResult = $this->keyboardController->readAllKeyboard();
        $keyboards = $keyboardsResult['data'];
        $keyboardsFiltered = $keyboards->where('category_id', $categoryId)->all();

        $data = ['category' => $category, 'keyboards' => $keyboardsFiltered];
        return RouteController::view('view', $data);
    }

    public function searchAllKeyboardByKeywords(Request $request)
    {
        $keywords = $request->keywords;
        $categoryId = $request->query('category_id');
        $categoryResult = $this->categoryController->readOneCategoryById($categoryId);
        $category = $categoryResult['data'];
        $keyboardsResult = $this->keyboardController->readAllKeyboard();
        $keyboards = $keyboardsResult['data'];
        $keyboardsFiltered = $keyboards->where('category_id', $categoryId)->where('name', 'like', '%' . $keywords . '%')->all();

        $data = ['category' => $category, 'keyboards' => $keyboardsFiltered];
        return RouteController::view('view', $data);
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
