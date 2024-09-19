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
        Schema::table('customer_kyc', function (Blueprint $table) {
             // First, if you're altering an existing table, make sure the column you're adding doesn't already exist.
        // Adding a new column to store the foreign key relationship
        // Make sure the column is an unsigned big integer to match the primary key type of the admin table
        $table->unsignedBigInteger('agentID')->default(0)->after('zip_file_name'); // Replace 'some_column' with the column after which you want to add the 'agentID'

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
        Schema::table('customer_kyc', function (Blueprint $table) {
            //
        });
    }
};
