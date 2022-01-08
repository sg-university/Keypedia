<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class LoginController extends Controller
{
    public $MESSAGE_LOGIN_CREDENTIALS_VALIDATION_FAILED = 'Failed to login because credentials validation failed';
    public $MESSAGE_LOGIN_CREDENTIALS_INVALID = 'Failed to login because invalid credentials';
    public $MESSAGE_LOGIN_CREDENTIALS_VALID = 'Suceed to login';

    public function index()
    {
        return view();
    }

    // login by model user by email and password with validation
    public function login($credentials)
    {
        // validation
        $validation = Validator::make(
            $credentials,
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_LOGIN_CREDENTIALS_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $user = User::where('email', $credentials['email'])->where('password', $credentials['password'])->first();
        if (!$user) {
            return ['message' => $this->MESSAGE_LOGIN_CREDENTIALS_INVALID, 'data' => null];
        }
        return ['message' => $this->MESSAGE_LOGIN_CREDENTIALS_VALID, 'data' => $user];
    }

    // test all method in this controller
    public function test()
    {
        $user = User::all()->random(1)->first();
        $credentialsValid = ['email' => $user->email, 'password' =>  $user->password];
        $credentialsInvalid = ['email' => $user->email, 'password' => 'invalid'];
        $credentialsValidationFailed = ['email' => 'invalid', 'password' => 'invalid'];

        $loginValid = $this->login($credentialsValid);
        $loginInvalid = $this->login($credentialsInvalid);
        $loginCredentialsFailed = $this->login($credentialsValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_LOGIN_CREDENTIALS_VALID, 'data' => $user], $loginValid);
        Assert::assertEquals(['message' => $this->MESSAGE_LOGIN_CREDENTIALS_INVALID, 'data' => null], $loginInvalid);
        Assert::assertEquals(['message' => $this->MESSAGE_LOGIN_CREDENTIALS_VALIDATION_FAILED, 'data' => $loginCredentialsFailed['data']], $loginCredentialsFailed);
    }
}
