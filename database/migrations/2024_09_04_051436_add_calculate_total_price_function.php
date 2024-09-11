<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        DROP FUNCTION IF EXISTS calculate_total_price;
        CREATE FUNCTION calculate_total_price(price DECIMAL(10,2), tax_rate DECIMAL(5,2))
        RETURNS DECIMAL(10,2)
        DETERMINISTIC
        BEGIN
            DECLARE total_price DECIMAL(10,2);
            SET total_price = price + (price * tax_rate / 100);
            RETURN total_price;
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_total_price');
    }
};
