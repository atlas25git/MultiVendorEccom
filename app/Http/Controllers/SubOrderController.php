<?php

namespace App\Http\Controllers;

use App\SubOrder;
use Illuminate\Http\Request;

class SubOrderController extends Controller
{
    public function pay(SubOrder $suborder)
    {
        $suborder->transactions()->create([
            'transaction_id'=> uniqid('trans-'.$suborder->id),
            'amount_paid'=> $suborder->grand_total,
            'commission'=>  0.8*$suborder->grand_total
        ]);

        return redirect()->to('https://www.sandbox.paypal.com/myaccount/transfer/homepage')->withMessage('Transaction Created');
    }
}
