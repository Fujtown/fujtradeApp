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
            CREATE TRIGGER after_foloosi_insert
            AFTER INSERT ON foloosis
            FOR EACH ROW
            BEGIN
                INSERT INTO payment_ladger (amount, currency, date, email, full_name, source_table) 
                VALUES (NEW.request_amount, NEW.request_currency, NOW(), NEW.customer_email, NEW.customer_name, "foloosis");
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foloosi_insert_trigger');
    }
};
