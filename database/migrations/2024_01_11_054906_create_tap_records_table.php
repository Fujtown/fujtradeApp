<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tap_records', function (Blueprint $table) {
            $table->id();
            $table->string('created', 40);
            $table->string('charge_id', 100);
            $table->string('track_no', 100);
            $table->string('payment_no', 100);
            $table->string('receipt_no', 100);
            $table->string('invoice_id', 100);
            $table->string('amount', 100);
            $table->string('currency', 40);
            $table->string('status', 100);
            $table->string('code', 100);
            $table->text('message');
            $table->string('brand', 100);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('customer_id', 100);
            $table->string('email', 100);
            $table->string('country_code', 100);
            $table->string('number', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tap_records');
    }
};
