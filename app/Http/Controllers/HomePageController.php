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
        $data = ['categories' => $this->readAllCategory()];
        return view('', $data);
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
