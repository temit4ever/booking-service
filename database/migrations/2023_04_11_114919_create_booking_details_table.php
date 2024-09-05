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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->string('venue_id');
            $table->integer('member_id')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->integer('number_of_guest')->nullable();
            $table->dateTime('book_date_time')->nullable();
            $table->string('fixture_name')->nullable();
            $table->string('special_requests')->nullable();
            $table->string('confirmation_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_response');
    }
};
