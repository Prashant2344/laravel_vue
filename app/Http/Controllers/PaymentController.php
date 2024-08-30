<?php

namespace App\Http\Controllers;

use App\Classes\OrderDetails;
use App\Classes\PaymentGateway;
use App\Interfaces\PaymentType;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(PaymentType $paymentGateway, OrderDetails $orderDetails){
        $orderDetails->order();
        dd($paymentGateway->charge(500));
    }
}
