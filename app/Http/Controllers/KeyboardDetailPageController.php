<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;

class KeyboardDetailPageController extends Controller
{
    public $keyboardController, $cartController;

    public function __construct()
    {
        $this->keyboardController = new KeyboardController();
        $this->cartController = new CartController();
    }

    public function index($id)
    {
        $keyboardResult = $this->readOneKeyboardById($id);
        if ($keyboardResult['message'] != $this->keyboardController->MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALID) {
            return abort(404);
        }
        $keyboard = $keyboardResult['data'];
        $user = Auth::user();
        $data = ['keyboard' => $keyboard, 'user' => $user];
        return RouteController::view('detail', $data);
    }

    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readOneKeyboardById($id);
    }

    public function createOneCartKeyboard(Request $request)
    {
        $userId = $request->user_id;
        $keyboardToCreate = [
            'keyboard_id' => $request->keyboard_id,
            'quantity' => $request->quantity,
        ];

        $cartKeyboardResult =  $this->cartController->createOneCartKeyboardByUserId($userId, $keyboardToCreate);

        if ($cartKeyboardResult['message'] != $this->cartController->MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALID) {
            return redirect()->back()->withErrors($cartKeyboardResult['data'])->withInput();
        }

        return redirect()->back()->with($cartKeyboardResult);
    }


    public function deleteOneKeyboardById($id)
    {
        $keyboardResult = $this->keyboardController->deleteOneKeyboardById($id);

        switch ($keyboardResult['message']) {
            case $this->keyboardController->MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALID:
                return redirect()->back()->with($keyboardResult);
                break;
            default:
                return redirect()->back()->withErrors($keyboardResult['data'])->withInput();
                break;
        }
        return $this->keyboardController->deleteOneKeyboardById($id);
    }

    // test all method in this controller
    public function test()
    {
    }
}
