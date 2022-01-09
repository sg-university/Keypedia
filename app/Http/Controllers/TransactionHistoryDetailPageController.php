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

    public function index()
    {
        $transactionKeyboardId = request()->transactionKeyboardId;

        $transactionKeyboard =  $this->readOneTransactionKeyboardById($transactionKeyboardId);
        $keyboard = $this->readOneKeyboardById($transactionKeyboard['data']->keyboard_id);
        $data = [
            'transactionKeyboard' => $transactionKeyboard,
            'keyboard' => $keyboard,
        ];
        return view('', $data);
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
