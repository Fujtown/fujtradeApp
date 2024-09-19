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
        Schema::create('payment_by_link', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('brand')->nullable();
            $table->string('ch_id')->nullable();
            $table->string('code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('currency');
            $table->string('customer_id')->nullable();
            $table->string('date');
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('last_name')->nullable();
            $table->string('message')->nullable();
            $table->string('number')->nullable();
            $table->string('payment')->nullable();
            $table->string('receipt')->nullable();
            $table->string('status');
            $table->string('tr_id')->nullable();
            $table->string('track')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
