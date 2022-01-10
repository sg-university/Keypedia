<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class HomePageController extends Controller
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
        return RouteController::view('index', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }

    // test all method in this controller
    public function test()
    {
    }
}
