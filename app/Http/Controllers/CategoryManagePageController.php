<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class CategoryManagePageController extends Controller
{
    public $categoryController;

    public function __construct()
    {
        $this->categoryController = new CategoryController();
    }

    public function index()
    {
        $categoriesResult =  $this->readAllCategory();
        $categories = $categoriesResult['data'];
        $data = ['categories' => $categories];
        return RouteController::view('manage', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }

    public function deleteOneCategoryById($id)
    {
        $categoryResult = $this->categoryController->deleteOneCategoryById($id);

        switch ($categoryResult['message']) {
            case $this->categoryController->MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALID:
                return redirect()->back()->with($categoryResult);
                break;
            default:
                return redirect()->back()->withErrors($categoryResult['data'])->withInput();
                break;
        }
        return $this->categoryController->deleteOneCategoryById($id);
    }

    // test all method in this controller
    public function test()
    {
    }
}
