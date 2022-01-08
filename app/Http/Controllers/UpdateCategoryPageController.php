<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class UpdateCategoryPageController extends Controller
{
    public $categoryController;

    public function __construct()
    {
        $this->categoryController = new CategoryController();
    }

    public function index()
    {
        $categryId = request()->categoryId;
        $data = ['categories' => $this->readOneCategoryById($categryId)];
        return view('', $data);
    }

    public function readOneCategoryById($id)
    {
        return $this->categoryController->readOneCategoryById($id);
    }

    public function updateOneCategoryById($id, $categoryToUpdate)
    {
        return $this->categoryController->updateOneCategoryById($id, $categoryToUpdate);
    }

    // test all method in this controller
    public function test()
    {
    }
}
