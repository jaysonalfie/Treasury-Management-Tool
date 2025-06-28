<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferTransactionController extends Controller
{
    //

    public function index()
    {
        return view('transactions.index');
    }

    public function create()
    {
        return view('transactions.create');
    }

}
