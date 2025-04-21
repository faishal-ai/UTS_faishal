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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('rentals_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('book_id')->index();
            $table->string('nama_penyewa');
            $table->date('rental_date');
            $table->date('return_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('book_id')->references('book_id')->on('books')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
