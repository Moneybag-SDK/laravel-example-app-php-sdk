<?php

namespace App\Http\Controllers;

use App\Models\MoneybagTransaction;
use Illuminate\Http\Request;

class MoneybagTransactionController extends Controller
{
    public function index()
    {
        $transactions = MoneybagTransaction::with('order')
            ->latest()
            ->paginate(20);
            
        return view('moneybag.transactions', compact('transactions'));
    }

    public function show(MoneybagTransaction $transaction)
    {
        $transaction->load('order.items.product');
        return view('moneybag.show', compact('transaction'));
    }
}