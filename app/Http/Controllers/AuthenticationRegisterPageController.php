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

class AuthenticationRegisterPageController extends Controller
{
    private $authenticationController;

    public function __construct()
    {
        $this->authenticationController = new AuthenticationController();
    }

    public function index()
    {
        $data = ['genders' => Gender::all()];
        return view('register', $data);
    }

    // register by model user by email and password with validation
    public function register(Request $credentials)
    {
        $result =  $this->authenticationController->register($credentials->toArray());

        switch ($result['message']) {
            case $this->authenticationController->MESSAGE_REGISTER_CREDENTIALS_VALID:
                return redirect()->route('authentication.login.index');
                break;
            default:
                return redirect()->back()->withErrors($result['data'])->withInput();
                break;
        }
    }

    // test all method in this controller
    public function test()
    {
    }
}
