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
        Schema::create('tap_payment_link', function (Blueprint $table) {
            $table->id();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('url')->nullable();
            $table->string('random_no')->nullable();
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
