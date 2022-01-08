<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class LoginPageController extends Controller
{
    private $authenticationController;

    public function __construct()
    {
        $this->authenticationController = new AuthenticationController();
    }

    public function index()
    {
        $data = [];
        return view('', $data);
    }

    // login by model user by email and password with validation
    public function login($credentials)
    {
        return $this->authenticationController->login($credentials);
    }

    // test all method in this controller
    public function test()
    {
    }
}
