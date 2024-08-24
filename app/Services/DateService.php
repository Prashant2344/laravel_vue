<?php
namespace App\Services;

use Carbon\Carbon;

class DateService
{
    public function getFormattedDate()
    {
        return Carbon::now()->format('Y-m-d');
    }
}
