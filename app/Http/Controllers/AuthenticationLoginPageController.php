<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use App\Form;

class AuthenticationLoginPageController extends Controller
{
    private $authenticationController;

    public function __construct()
    {
        $this->authenticationController = new AuthenticationController();
    }

    public function index()
    {
        $data = [];
        return view('login', $data);
    }

    // login by model user by email and password with validation
    public function login(Request $credentials)
    {
        $result =  $this->authenticationController->login($credentials->toArray());

        switch ($result['message']) {
            case $this->authenticationController->MESSAGE_LOGIN_CREDENTIALS_VALID:
                return redirect()->route('customer.home.index');
                break;
            case $this->authenticationController->MESSAGE_LOGIN_CREDENTIALS_INVALID:
                return redirect()->back()->withErrors([$result['message']]);
                break;
            default:
                return redirect()->back()->withErrors($result['data']);
                break;
        }
    }

    // test all method in this controller
    public function test()
    {
    }
}
