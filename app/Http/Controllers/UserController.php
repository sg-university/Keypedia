<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class UserController extends Controller
{
    public $MESSAGE_READ_ONE_USER_BY_ID_VALID = 'Suceed to read one user by id.';
    public $MESSAGE_READ_ONE_USER_BY_ID_VALIDATION_FAILED = 'Failed to read one user by id because validation failed.';

    public $MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALID = 'Suceed to change one user pasword by id.';
    public $MESSAGE_CHANGE_USER_PASSWORD_BY_ID_INVALID = 'Failed to change one user pasword by id because invalid credentials.';
    public $MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALIDATION_FAILED = 'Failed to change one user pasword by id because validation failed.';

    public function readOneUserById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|exists:User,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_READ_ONE_USER_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $user =  User::find($id);

        return ['message' => $this->MESSAGE_READ_ONE_USER_BY_ID_VALID, 'data' => $user,];
    }

    public function changeUserPasswordById($id, $credentials)
    {
        $credentials['id'] = $id;
        $validation = Validator::make(
            $credentials,
            [
                'id' => 'required|exists:User,id',
                'password' => 'required|min:8',
                'new_password' => 'required|min:8',
                'new_password_confirmation' => 'required|same:new_password|min:8',
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $user =  User::find($credentials['id'])->where('password', $credentials['password'])->first();
        if (!$user) {
            return ['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_INVALID, 'data' => null];
        }

        $user->password = $credentials['new_password'];
        $user->save();

        return ['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALID, 'data' => $user];
    }

    public function testReadOneUserById()
    {

        $user = User::all()->random(1)->first();

        $readOneUserByIdValid = $this->readOneUserById($user->id);
        $readOneUserByIdValidationFailed = $this->readOneUserById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_USER_BY_ID_VALID, 'data' => $user], $readOneUserByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_USER_BY_ID_VALIDATION_FAILED, 'data' => $readOneUserByIdValidationFailed['data']], $readOneUserByIdValidationFailed);
    }

    public function testChangeUserPasswordById()
    {
        $user = User::all()->random(1)->first();

        $credentialsValid = ['password' => $user->password, 'new_password' => 'new_password', 'new_password_confirmation' => 'new_password'];
        $credentialsInvalid = ['password' => 'tidakmungkin', 'new_password' => 'new_password', 'new_password_confirmation' => 'new_password'];
        $credentialsValidationFailed = ['password' => null, 'new_password' => null, 'new_password_confirmation' => null];
        $changeUserPasswordByIdValid = $this->changeUserPasswordById($user->id, $credentialsValid);
        $changeUserPasswordByIdInvalid = $this->changeUserPasswordById($user->id, $credentialsInvalid);
        $changeUserPasswordByIdValidationFailed = $this->changeUserPasswordById(null, $credentialsValidationFailed);
        Assert::assertEquals(['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALID, 'data' => $changeUserPasswordByIdValid['data']], $changeUserPasswordByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_INVALID, 'data' => $changeUserPasswordByIdInvalid['data']], $changeUserPasswordByIdInvalid);
        Assert::assertEquals(['message' => $this->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALIDATION_FAILED, 'data' => $changeUserPasswordByIdValidationFailed['data']], $changeUserPasswordByIdValidationFailed);
    }

    // test all method in this controller
    public function test()
    {
        $this->testReadOneUserById();
        $this->testChangeUserPasswordById();
    }
}
