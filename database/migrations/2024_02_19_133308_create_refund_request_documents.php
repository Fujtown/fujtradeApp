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
        Schema::create('refund_request_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id'); // Match the type with the primary key type of the referenced table
            $table->string('refund_documents',1000)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('refund_id')->references('id')->on('refund_request')
            ->onDelete('cascade') // or ->onDelete('restrict'), depending on your needs
            ->onUpdate('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_request_documents');
    }
};
