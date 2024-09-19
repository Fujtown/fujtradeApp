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
        Schema::create('tap_refunds', function (Blueprint $table) {
            $table->id();
            $table->string('Refund_req_date');
            $table->string('Refund_date')->nullable();
            $table->string('ch_id')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('merchent_id')->nullable();
            $table->string('code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('currency');
            $table->string('customer_id')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('last_name')->nullable();
            $table->string('message')->nullable();
            $table->string('number')->nullable();
            $table->string('country_amount')->nullable();
            $table->string('exchange_amount')->nullable();
            $table->string('reason')->nullable();
            $table->string('receipt')->nullable();
            $table->string('status');
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
