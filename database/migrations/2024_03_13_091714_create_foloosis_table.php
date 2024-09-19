<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::create('foloosis', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->string('receipt')->nullable();
            $table->string('request_currency');
            $table->decimal('request_amount', 10, 2);
            $table->string('customer_currency');
            $table->decimal('customer_amount', 10, 2);
            $table->string('merchant_currency');
            $table->decimal('merchant_amount', 10, 2);
            $table->string('status');
            $table->text('payment_failed_reason')->nullable();
            $table->timestamp('created_at_foloosi')->nullable(); // "created" from the data, but renamed to avoid confusion with Laravel's created_at
            $table->string('optional1')->nullable();
            $table->string('optional2')->nullable();
            $table->string('optional3')->nullable();
            $table->string('subscription_no')->nullable();
            // Customer data
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone_number');
            // Card data
            $table->string('pan')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bin_card')->nullable();
            $table->string('issuer_name')->nullable();
            $table->string('issuer_country')->nullable();
            $table->string('card_expiry')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('card_reference')->nullable();
            $table->bigInteger('card_id')->nullable();
            $table->string('card_bin')->nullable();
            $table->string('bin_bank')->nullable();
            $table->string('bin_type')->nullable();
            $table->string('bin_level')->nullable();
            $table->string('bin_country_code')->nullable();
            $table->string('bin_website')->nullable();
            $table->string('bin_phone')->nullable();
            $table->boolean('bin_valid')->nullable();
            $table->string('card_issuer')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foloosis');
    }
};

