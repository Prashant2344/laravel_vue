<?php

namespace App\Classes;
use App\Classes\PaymentGateway;
use App\Interfaces\PaymentType;

class OrderDetails {
    private $paymentGateway;

    public function __construct(PaymentType $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function order()
    {
        $this->paymentGateway->setDiscount(5);

        return [
            'name' => 'Prashant Silpakar',
            'address' => 'Kalimati,Kathmandu'
        ];
    }
}