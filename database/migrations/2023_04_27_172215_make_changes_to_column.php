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
        Schema::table('booking_details', function (Blueprint $table) {
            $table->renameColumn('confirmation_code', 'booking_id');
            $table->dateTime('created_at')->useCurrent()->change();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->change();
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
