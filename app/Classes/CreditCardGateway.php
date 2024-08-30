<?php

namespace App\Classes;

use Illuminate\Support\Str;
use App\Interfaces\PaymentType;

class CreditCardGateway implements PaymentType{
    private $currency;
    private $discount;
    public function __construct($currency)
    {
        $this->currency = $currency;
        $this->discount = 0;
    }

    public function setDiscount($amt){
        $this->discount = $amt;
    }

    public function charge($amount)
    {
        return [
            'amount' => $amount - $this->discount,
            'conformationCode' => Str::random(),
            'currency' => $this->currency,
            'discount' => $this->discount,
            'fee' => '0.03'
        ];
    }
}