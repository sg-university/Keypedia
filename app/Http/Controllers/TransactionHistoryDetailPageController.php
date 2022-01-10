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
    private $transactionController;

    public function __construct()
    {
        $this->transactionController = new TransactionController();
    }

    public function index($id)
    {
        $transaction =  $this->readOneTransactionById($id);
        $data = [
            'transaction' => $transaction
        ];
        return RouteController::view('historydetail', $data);
    }

    public function readOneTransactionById($id)
    {
        $transactionsResult = $this->transactionController->readAllTransaction();
        $transactions = $transactionsResult['data'];
        $transaction = $transactions->where('id', $id)->first();
        return $transaction;
    }

    public function readOneKeyboardById($id)
    {
        return  $this->keyboardController->readKeyboardById($id);
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
