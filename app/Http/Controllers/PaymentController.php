<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function show(int $id)
    {
        $payment = Payment::with('house', 'user', 'reversedBy')->findOrFail($id);

        return view('payments.index', compact('payment'));
    }
}
