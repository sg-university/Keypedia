<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class ChangePasswordPageController extends Controller
{
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController();
    }

    public function index()
    {
        $userId = request()->userId;
        $data = ['user' => $this->readOneUserById($userId)];
        return view('', $data);
    }

    public function readOneUserById($id)
    {
        return $this->userController->readOneUserById($id);
    }

    public function changeUserPasswordById($id, $credentials)
    {
        return $this->userController->changeUserPasswordById($id, $credentials);
    }

    // test all method in this controller
    public function test()
    {
    }
}
