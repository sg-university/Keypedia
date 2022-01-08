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

class RegisterController extends Controller
{
    public $MESSAGE_REGISTER_CREDENTIALS_VALIDATION_FAILED = 'Failed to register because credentials validation failed';
    public $MESSAGE_REGISTER_CREDENTIALS_INVALID = 'Failed to register because invalid credentials';
    public $MESSAGE_REGISTER_CREDENTIALS_VALID = 'Suceed to register';

    public function index()
    {
        return view();
    }

    // register by model user by email and password with validation
    public function register($credentials)
    {
        // validation
        $validation = Validator::make(
            $credentials,
            [
                'name' => 'required',
                'username' => 'required|min:5|unique:User,username',
                'email' => 'required|email|unique:User,email',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password|min:8',
                'address' => 'required|min:10',
                'gender' => 'required|exists:gender,name',
                'dob' => 'required|date'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_REGISTER_CREDENTIALS_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $user = $this->mapCredentialsToUser($credentials);
        $user->save();

        if (!$user) {
            return ['message' => $this->MESSAGE_REGISTER_CREDENTIALS_INVALID, 'data' => null];
        }
        return ['message' => $this->MESSAGE_REGISTER_CREDENTIALS_VALID, 'data' => $user,];
    }

    public function mapCredentialsToUser($credentials)
    {
        $user = new User();
        $user->role_id = Role::where('name', 'customer')->first()->id;
        $user->username = $credentials['username'];
        $user->email = $credentials['email'];
        $user->password = $credentials['password'];
        $user->name = $credentials['name'];
        $user->gender_id = Gender::where('name', $credentials['gender'])->first()->id;
        $user->address = $credentials['address'];
        $user->dob = $credentials['dob'];
        return $user;
    }

    // test all method in this controller
    public function test()
    {
        $faker = Faker::create();
        $credentialsValid = [
            'username' => Str::random(8),
            'email' => $faker->email,
            'password' => "12345678",
            'password_confirmation' => "12345678",
            'name' => $faker->name,
            'gender' => Gender::all()->random(1)->first()->name,
            'address' => $faker->address,
            'dob' => date("Y-m-d H:i:s")
        ];

        $credentialsValidationFailed = [
            'usernamexx' => null,
            'username' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'name' =>  null,
            'gender' => null,
            'address' => null,
            'dob' => null
        ];

        $user = $this->mapCredentialsToUser($credentialsValid);
        $registerValid = $this->register($credentialsValid);
        $registerCredentialsFailed = $this->register($credentialsValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_REGISTER_CREDENTIALS_VALID, 'data' => $registerValid['data']], $registerValid);
        Assert::assertEquals(['message' => $this->MESSAGE_REGISTER_CREDENTIALS_VALIDATION_FAILED, 'data' => $registerCredentialsFailed['data']], $registerCredentialsFailed);
    }
}
