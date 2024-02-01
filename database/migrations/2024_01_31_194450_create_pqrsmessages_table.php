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
        Schema::create('pqrsmessages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pqrs_id')->references('id')->on('pqrs');
            $table->foreignId('sender_id')->references('id')->on('users');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pqrsmessages');
    }
};
