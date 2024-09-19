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
        Schema::table('payment_by_link', function (Blueprint $table) {
            $table->unsignedBigInteger('agentID')->default(0)->after('track'); // Replace 'some_column' with the column after which you want to add the 'agentID'

            // Adding the foreign key constraint
            $table->foreign('agentID')->references('id')->on('admin')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_by_link', function (Blueprint $table) {
            //
        });
    }
};
