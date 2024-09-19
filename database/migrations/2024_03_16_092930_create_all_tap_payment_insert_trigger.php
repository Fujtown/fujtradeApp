<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        DB::unprepared('
            CREATE TRIGGER after_all_tap_payment_insert
            AFTER INSERT ON all_tap_payment
            FOR EACH ROW
            BEGIN
                INSERT INTO payment_ladger (amount, currency, date, email, full_name, source_table) 
                VALUES (NEW.amount, NEW.currency, NEW.date, NEW.email, CONCAT(NEW.first_name, \' \', NEW.last_name), \'all_tap_payment\');
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_tap_payment_insert_trigger');
    }
};
