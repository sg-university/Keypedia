<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionKeyboard;
use App\Models\Keyboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TransactionHistoryDetailPageController extends Controller
{
    private $transactionController, keyboardController;

    public function __construct()
    {
        $this->transactionController = new TransactionController();
        $this->keyboardController = new KeyboardController();
    }

    public function index()
    {
        $userId = request()->userId;
        $transactionKeyboardId = request()->transactionKeyboardId;

        $userTransactionKeyboards = $this->readAllTransactionKeyboardByUserId($userId);
        $transactionKeyboard =  $this->readOneTransactionKeyboardById($transactionKeyboardId);
        $keyboard = $this->readOneKeyboardById($transactionKeyboard['data']->keyboard_id);
        $data = [
            'userTransactionKeboards' => $userTransactionKeyboards,
            'transactionKeyboard' => $transactionKeyboard,
            'keyboard' => $keyboard,
        ];
        return view('', $data);
    }

    public function readAllTransactionKeyboardByUserId($userId)
    {
        $transactions = $this->transactionController->readAllTransaction();
        $userTransactions = $transactions['data']->where('user_id', $userId);
        $userTransactionKeyboards = $userTransactions->keyboards;
        return $userTransactionKeyboards;
    }

    public function readOneKeyboardById($id)
    {
        $return = $this->keyboardController->readKeyboardById($id);
    }

    public function readAllTransactionKeyboard()
    {
        return $this->transactionController->readAllTransactionKeyboard();
    }

    public function readOneTransactionKeyboardById($id)
    {
        return $this->transactionController->readOneTransactionKeyboardById($id);
    }


    // test all method in this controller
    public function test()
    {
    }
}
