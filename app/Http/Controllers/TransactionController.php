<?php

namespace App\Http\Controllers;

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

class TransactionController extends Controller
{
    public $MESSAGE_READ_ALL_TRANSACTION_VALID = 'Succeed to read all transaction.';

    public $MESSAGE_READ_ALL_TRANSACTION_KEYBOARD_VALID = 'Succeed to read all transaction keyboard.';

    public $MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID = 'Succeed to read one transaction keyboard by id.';
    public $MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to read one transaction keyboard by id because validation failed.';

    public $MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALID = 'Succeed to create one transaction keyboard.';
    public $MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALIDATION_FAILED = 'Failed to create one transaction keyboard because validation failed.';

    public $MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID = 'Succeed to update one transaction keyboard by id.';
    public $MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to update one transaction keyboard by id because validation failed.';

    public $MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID = 'Succeed to delete one transaction keyboard by id.';
    public $MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to delete one transaction keyboard by id because validation failed.';

    public function readAllTransaction()
    {
        return ['message' => $this->MESSAGE_READ_ALL_CART_VALID, 'data' => Transaction::all()];
    }

    public function readAllTransactionKeyboard()
    {
        return ['message' => $this->MESSAGE_READ_ALL_TRANSACTION_KEYBOARD_VALID, 'data' => Transaction::all()->keyboards];
    }

    public function createOneTransactionKeyboardByUserId($userId, $transactionKeyboardToCreateByUserId)
    {
        $transactionKeyboardToCreateByUserId['user_id'] = $userId;
        $validation = Validator::make(
            $transactionKeyboardToCreateByUserId,
            [
                'user_id' => 'required|exists:user,id',
                'keyboard_id' => 'required|exists:keyboard,id',
                'quantity' => 'required|integer|min:1',
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        // if user transaction exists, then attach keyboard id to transaction keyboard
        $user = User::find($userId);
        $transaction = $user->transaction;
        if (!$transaction) {
            $transaction = Transaction::create(['user_id' => $userId]);
        }

        $transaction->keyboards()->attach([$transactionKeyboardToCreateByUserId['keyboard_id'] => ['quantity' => $transactionKeyboardToCreateByUserId['quantity']]]);


        return ['message' => $this->MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALID, 'data' => $transaction];
    }

    public function readOneTransactionKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            [
                'id' => 'required|exists:transaction_keyboard,id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $transactionKeyboard = TransactionKeyboard::where('id', $id)->first();

        return ['message' => $this->MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $transactionKeyboard];
    }

    public function updateOneTransactionKeyboardById($id, $transactionKeyboardToUpdate)
    {
        $transactionKeyboardToUpdate['id'] = $id;
        $validation = Validator::make(
            $transactionKeyboardToUpdate,
            [
                'id' => 'required|exists:transaction_keyboard,id',
                'keyboard_id' => 'required|exists:keyboard,id',
                'quantity' => 'required|integer|min:1'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $transactionKeyboard = TransactionKeyboard::where('id', $id)->first();
        $transactionKeyboard->keyboard_id = $transactionKeyboardToUpdate['keyboard_id'];
        $transactionKeyboard->quantity = $transactionKeyboardToUpdate['quantity'];
        $transactionKeyboard->save();

        return ['message' => $this->MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $transactionKeyboard];
    }

    public function deleteOneTransactionKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            [
                'id' => 'required|exists:transaction_keyboard,id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $transactionKeyboard = TransactionKeyboard::where('id', $id)->first();

        return ['message' => $this->MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $transactionKeyboard];
    }

    public function testReadOneTransactionKeyboardById()
    {
        $transactionKeyboard = TransactionKeyboard::all()->random(1)->first();

        $readOneTransactionKeyboardByIdValid = $this->readOneTransactionKeyboardById($transactionKeyboard->id);
        $readOneTransactionKeyboardByIdValidationFailed = $this->readOneTransactionKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $transactionKeyboard], $readOneTransactionKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $readOneTransactionKeyboardByIdValidationFailed['data']], $readOneTransactionKeyboardByIdValidationFailed);
    }

    public function testCreateOneTransactionKeyboardByUserId()
    {
        $user = User::all()->random(1)->first();
        $transactionKeyboardToCreateByUserIdValid = [
            'keyboard_id' => Keyboard::all()->random(1)->first()->id,
            'quantity' => rand(1, 10),
        ];
        $transactionKeyboardToCreateByUserIdValidationFailed = [
            'user_id' => null,
            'keyboard_id' => null,
            'quantity' => null
        ];

        $createOneTransactionKeyboardByUserIdValid = $this->createOneTransactionKeyboardByUserId($user->id, $transactionKeyboardToCreateByUserIdValid);
        $createTransactionKeyboardByUserIdValidationFailed = $this->createOneTransactionKeyboardByUserId($user->id, $transactionKeyboardToCreateByUserIdValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALID, 'data' => $createOneTransactionKeyboardByUserIdValid['data']], $createOneTransactionKeyboardByUserIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_TRANSACTION_KEYBOARD_BY_USER_ID_VALIDATION_FAILED, 'data' => $createTransactionKeyboardByUserIdValidationFailed['data']], $createTransactionKeyboardByUserIdValidationFailed);
    }

    public function testUpdateOneTransactionKeyboardById()
    {
        $transactionKeyboard = TransactionKeyboard::all()->random(1)->first();

        $transactionKeyboardToUpdateValid = [
            'user_id' => User::all()->random(1)->first()->id,
            'keyboard_id' => Keyboard::all()->random(1)->first()->id,
            'quantity' => rand(1, 10),
        ];
        $transactionKeyboardToUpdateValidationFailed = [
            'id' => null,
            'keyboard_id' => null,
            'quantity' => null
        ];

        $updateOneTransactionKeyboardByIdValid = $this->updateOneTransactionKeyboardById($transactionKeyboard->id, $transactionKeyboardToUpdateValid);
        $createTransactionKeyboardByUserIdValidationFailed = $this->updateOneTransactionKeyboardById($transactionKeyboard->id, $transactionKeyboardToUpdateValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $updateOneTransactionKeyboardByIdValid['data']], $updateOneTransactionKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $createTransactionKeyboardByUserIdValidationFailed['data']], $createTransactionKeyboardByUserIdValidationFailed);
    }

    public function testDeleteOneTransactionKeyboardById()
    {
        $transactionKeyboard = TransactionKeyboard::all()->random(1)->first();

        $deleteOneTransactionKeyboardByIdValid = $this->deleteOneTransactionKeyboardById($transactionKeyboard->id);
        $deleteOneTransactionKeyboardByIdValidationFailed = $this->deleteOneTransactionKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALID, 'data' => $deleteOneTransactionKeyboardByIdValid['data']], $deleteOneTransactionKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_TRANSACTION_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $deleteOneTransactionKeyboardByIdValidationFailed['data']], $deleteOneTransactionKeyboardByIdValidationFailed);
    }


    // test all method in this controller
    public function test()
    {
        $this->testReadOneTransactionKeyboardById();
        $this->testCreateOneTransactionKeyboardByUserId();
        $this->testUpdateOneTransactionKeyboardById();
        $this->testDeleteOneTransactionKeyboardById();
    }
}
