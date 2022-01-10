<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Illuminate\Support\Str;

class CategoryUpdatePageController extends Controller
{
    public $categoryController;

    public function __construct()
    {
        $this->categoryController = new CategoryController();
    }

    public function index($id)
    {
        $categoryResult = $this->readOneCategoryById($id);
        if ($categoryResult['message'] != $this->categoryController->MESSAGE_READ_ONE_CATEGORY_BY_ID_VALID) {
            return abort(404);
        }
        $category = $categoryResult['data'];
        $data = ['category' => $category];
        return RouteController::view('updateCategory', $data);
    }

    public function readOneCategoryById($id)
    {
        return $this->categoryController->readOneCategoryById($id);
    }

    public function updateOneCategoryById($id, Request $request)
    {
        $imageId = Str::uuid()->toString();
        $categoryToUpdate = [
            'name' => $request->name,
            'image_id' => $imageId,
        ];

        $categoryResult = $this->categoryController->updateOneCategoryById($id, $categoryToUpdate);

        switch ($categoryResult['message']) {
            case $this->categoryController->MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALID:
                return redirect()->back()->with($categoryResult);
                break;
            default:
                return redirect()->back()->withErrors($categoryResult['data'])->withInput();
                break;
        }
    }

    // test all method in this controller
    public function test()
    {
    }
}
