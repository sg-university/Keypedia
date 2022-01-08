<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartKeyboard;
use App\Models\Keyboard;
use App\Models\Transaction;
use App\Models\TransactionKeyboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public $MESSAGE_READ_ALL_CART_VALID = 'Succeed to read all cart keyboard.';

    public $MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALID = 'Succeed to read one cart keyboard by id.';
    public $MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to read one cart keyboard by id because validation failed.';

    public $MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALID = 'Succeed to create one cart keyboard.';
    public $MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALIDATION_FAILED = 'Failed to create one cart keyboard because validation failed.';

    public $MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALID = 'Succeed to update one cart keyboard by id.';
    public $MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to update one cart keyboard by id because validation failed.';

    public $MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALID = 'Succeed to delete one cart keyboard by id.';
    public $MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to delete one cart keyboard by id because validation failed.';

    public $MESSAGE_CHECKOUT_CART_BY_USER_ID_VALID = 'Succeed to checkout cart by user id.';
    public $MESSAGE_CHECKOUT_CART_BY_USER_ID_INVALID = 'Failed to checkout cart by user id because cart not found.';
    public $MESSAGE_CHECKOUT_CART_BY_USER_ID_VALIDATION_FAILED = 'Failed to checkout cart by user id because validation failed.';


    public function readAllCartKeyboard()
    {
        return ['message' => $this->MESSAGE_READ_ALL_CART_VALID, 'data' => Cart::all()->keyboards];
    }

    public function createOneCartKeyboardByUserId($userId, $cartKeyboardToCreateByUserId)
    {
        $cartKeyboardToCreateByUserId['user_id'] = $userId;
        $validation = Validator::make(
            $cartKeyboardToCreateByUserId,
            [
                'user_id' => 'required|exists:user,id',
                'keyboard_id' => 'required|exists:keyboard,id',
                'quantity' => 'required|integer|min:1',
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        // if user cart exists, then attach keyboard id to cart keyboard
        $user = User::find($userId);
        $cart = $user->cart;
        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }

        $cart->keyboards()->attach([$cartKeyboardToCreateByUserId['keyboard_id'] => ['quantity' => $cartKeyboardToCreateByUserId['quantity']]]);


        return ['message' => $this->MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALID, 'data' => $cart];
    }

    public function readOneCartKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            [
                'id' => 'required|exists:cart_keyboard,id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $cartKeyboard = CartKeyboard::where('id', $id)->first();

        return ['message' => $this->MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $cartKeyboard];
    }

    public function updateOneCartKeyboardById($id, $cartKeyboardToUpdate)
    {
        $cartKeyboardToUpdate['id'] = $id;
        $validation = Validator::make(
            $cartKeyboardToUpdate,
            [
                'id' => 'required|exists:cart_keyboard,id',
                'keyboard_id' => 'required|exists:keyboard,id',
                'quantity' => 'required|integer|min:1'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $cartKeyboard = CartKeyboard::where('id', $id)->first();
        $cartKeyboard->keyboard_id = $cartKeyboardToUpdate['keyboard_id'];
        $cartKeyboard->quantity = $cartKeyboardToUpdate['quantity'];
        $cartKeyboard->save();

        return ['message' => $this->MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $cartKeyboard];
    }

    public function deleteOneCartKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            [
                'id' => 'required|exists:cart_keyboard,id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $cartKeyboard = CartKeyboard::where('id', $id)->first();

        return ['message' => $this->MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $cartKeyboard];
    }

    public function checkoutCartByUserId($userId)
    {
        $validation = Validator::make(
            ['user_id' => $userId],
            ['user_id' => 'required|exists:user,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $user = User::find($userId);
        $cart = $user->cart;

        if (!$cart) {
            return ['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_INVALID, 'data' => null];
        }

        $cartKeyboards = CartKeyboard::where('cart_id', $cart->id);

        $transaction = Transaction::create(['user_id' => $userId]);
        foreach ($cartKeyboards as $cartKeyboard) {
            $keyboard = Keyboard::find($cartKeyboard->keyboard_id);
            $transactionKeyboard = TransactionKeyboard::create([
                'transaction_id' => $transaction->id,
                'keyboard_id' => $keyboard->id,
                'quantity' => $cartKeyboard->quantity
            ]);
            $keyboard->stock = $keyboard->stock - $$transactionKeyboard->quantity;
            $keyboard->save();

            $cart->keyboards()->detach($cartKeyboard->keyboard_id);
        }


        return ['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALID, 'data' => $cartKeyboards];
    }

    public function testReadOneCartKeyboardById()
    {
        $cartKeyboard = CartKeyboard::all()->random(1)->first();

        $readOneCartKeyboardByIdValid = $this->readOneCartKeyboardById($cartKeyboard->id);
        $readOneCartKeyboardByIdValidationFailed = $this->readOneCartKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $cartKeyboard], $readOneCartKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $readOneCartKeyboardByIdValidationFailed['data']], $readOneCartKeyboardByIdValidationFailed);
    }

    public function testCreateOneCartKeyboardByUserId()
    {
        $user = User::all()->random(1)->first();
        $cartKeyboardToCreateByUserIdValid = [
            'keyboard_id' => Keyboard::all()->random(1)->first()->id,
            'quantity' => rand(1, 10),
        ];
        $cartKeyboardToCreateByUserIdValidationFailed = [
            'user_id' => null,
            'keyboard_id' => null,
            'quantity' => null
        ];

        $createOneCartKeyboardByUserIdValid = $this->createOneCartKeyboardByUserId($user->id, $cartKeyboardToCreateByUserIdValid);
        $createCartKeyboardByUserIdValidationFailed = $this->createOneCartKeyboardByUserId($user->id, $cartKeyboardToCreateByUserIdValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALID, 'data' => $createOneCartKeyboardByUserIdValid['data']], $createOneCartKeyboardByUserIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_CART_KEYBOARD_BY_USER_ID_VALIDATION_FAILED, 'data' => $createCartKeyboardByUserIdValidationFailed['data']], $createCartKeyboardByUserIdValidationFailed);
    }

    public function testUpdateOneCartKeyboardById()
    {
        $cartKeyboard = CartKeyboard::all()->random(1)->first();

        $cartKeyboardToUpdateValid = [
            'user_id' => User::all()->random(1)->first()->id,
            'keyboard_id' => Keyboard::all()->random(1)->first()->id,
            'quantity' => rand(1, 10),
        ];
        $cartKeyboardToUpdateValidationFailed = [
            'id' => null,
            'keyboard_id' => null,
            'quantity' => null
        ];

        $updateOneCartKeyboardByIdValid = $this->updateOneCartKeyboardById($cartKeyboard->id, $cartKeyboardToUpdateValid);
        $createCartKeyboardByUserIdValidationFailed = $this->updateOneCartKeyboardById($cartKeyboard->id, $cartKeyboardToUpdateValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $updateOneCartKeyboardByIdValid['data']], $updateOneCartKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $createCartKeyboardByUserIdValidationFailed['data']], $createCartKeyboardByUserIdValidationFailed);
    }

    public function testDeleteOneCartKeyboardById()
    {
        $cartKeyboard = CartKeyboard::all()->random(1)->first();

        $deleteOneCartKeyboardByIdValid = $this->deleteOneCartKeyboardById($cartKeyboard->id);
        $deleteOneCartKeyboardByIdValidationFailed = $this->deleteOneCartKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALID, 'data' => $deleteOneCartKeyboardByIdValid['data']], $deleteOneCartKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_CART_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $deleteOneCartKeyboardByIdValidationFailed['data']], $deleteOneCartKeyboardByIdValidationFailed);
    }

    public function testCheckoutCartByUserId()
    {
        $users = User::all()->random(2);
        $userCartValid = $users[0];
        $userCartInvalid = $users[1];

        $cart = $this->createOneCartKeyboardByUserId($userCartValid->id, [
            'keyboard_id' => Keyboard::all()->random(1)->first()->id,
            'quantity' => rand(1, 10),
        ]);

        $checkoutCartByUserIdValid = $this->checkoutCartByUserId($userCartValid->id);
        $checkoutCartByUserIdInvalid = $this->checkoutCartByUserId($userCartInvalid->id);
        $checkoutCartByUserIdValidationFailed = $this->checkoutCartByUserId(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALID, 'data' => $checkoutCartByUserIdValid['data']], $checkoutCartByUserIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_INVALID, 'data' => $checkoutCartByUserIdInvalid['data']], $checkoutCartByUserIdInvalid);
        Assert::assertEquals(['message' => $this->MESSAGE_CHECKOUT_CART_BY_USER_ID_VALIDATION_FAILED, 'data' => $checkoutCartByUserIdValidationFailed['data']], $checkoutCartByUserIdValidationFailed);
    }

    // test all method in this controller
    public function test()
    {
        $this->testReadOneCartKeyboardById();
        $this->testCreateOneCartKeyboardByUserId();
        $this->testUpdateOneCartKeyboardById();
        $this->testDeleteOneCartKeyboardById();
        $this->testCheckoutCartByUserId();
    }
}
