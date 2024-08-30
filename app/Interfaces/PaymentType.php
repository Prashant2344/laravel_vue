<?php

namespace App\Interfaces;

interface PaymentType {
    public function charge($amount);
    public function setDiscount($amt);
}