<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\DateService;
use Carbon\Carbon;

class DateServiceTest extends TestCase
{
    public function it_returns_a_formatted_date()
    {
        // Create an instance of the service class
        $service = new DateService();

        // Call the method
        $result = $service->getFormattedDate();

        // Define the expected format and date
        $expectedFormat = 'Y-m-d'; // Example format, adjust as needed
        $expectedDate = Carbon::now()->format($expectedFormat);

        // Assert that the result is a string
        $this->assertIsString($result);

        // Assert that the result matches the expected format
        $this->assertEquals($expectedDate, $result);
    }
}

