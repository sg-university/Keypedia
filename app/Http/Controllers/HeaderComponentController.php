<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class HeaderComponentController extends Controller
{
    private $userController, $categoryController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->categoryController = new CategoryController();
    }

    public function index()
    {
        $userId = request()->userId;
        $userResult = $this->readOneUserById($userId);
        $user = $userResult['data'];
        $data = ['user' => $user, 'date_time' => date('Y-m-d H:i:s')];
        return view('', $data);
    }

    public function readAllCategory()
    {
        return $this->categoryController->readAllCategory();
    }

    public function readOneUserById($id)
    {
        return $this->userController->readOneUserById($id);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('authentication.login.index');
    }



    // test all method in this controller
    public function test()
    {
    }
}
