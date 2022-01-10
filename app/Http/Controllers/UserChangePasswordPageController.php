<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class UserChangePasswordPageController extends Controller
{
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController();
    }

    public function index()
    {
        $user = Auth::user();
        $data = ['user' => $user];
        return RouteController::view('password', $data);
    }

    public function readOneUserById($id)
    {
        return $this->userController->readOneUserById($id);
    }

    public function changeUserPasswordById($id, Request $request)
    {
        $credentials = [
            'password' => $request->password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ];
        $userResult =  $this->userController->changeUserPasswordById($id, $credentials);

        switch ($userResult['message']) {
            case $this->userController->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_VALID:
                return redirect()->back()->with($userResult)->withInput();
                break;
            case $this->userController->MESSAGE_CHANGE_USER_PASSWORD_BY_ID_INVALID:
                return redirect()->back()->withErrors([$userResult['message']])->withInput();
                break;
            default:
                return redirect()->back()->withErrors($userResult['data'])->withInput();
                break;
        }
    }

    // test all method in this controller
    public function test()
    {
    }
}
