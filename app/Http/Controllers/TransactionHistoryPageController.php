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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionHistoryPageController extends Controller
{
    private $transactionController, $keyboardController;

    public function __construct()
    {
        $this->transactionController = new TransactionController();
        $this->keyboardController = new KeyboardController();
    }


    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $userTransactions = $this->readAllTransactionByUserId($userId);
        $data = [
            'userTransactions' => $userTransactions,
        ];
        return RouteController::view('history', $data);
    }

    public function readAllTransactionKeyboard()
    {
        return $this->transactionController->readAllTransactionKeyboard();
    }

    public function readAllTransactionByUserId($userId)
    {
        $transactions = $this->transactionController->readAllTransaction();
        $userTransactionKeyboards = $transactions['data']->where('user_id', $userId)->all();
        return $userTransactionKeyboards;
    }


    public function readOneTransactionKeyboardById($id)
    {
        return $this->transactionController->readOneTransactionKeyboardById($id);
    }


    public function readOneKeyboardById($id)
    {
        return $this->keyboardController->readKeyboardById($id);
    }


    // test all method in this controller
    public function test()
    {
    }
}
