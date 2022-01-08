<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class RegisterPageController extends Controller
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

    // register by model user by email and password with validation
    public function register($credentials)
    {
        return $this->authenticationController->register($credentials);
    }

    // test all method in this controller
    public function test()
    {
    }
}
