<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public array $venueArray = [
        '17547',
        '751',
        '122088'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (app()->environment(['local', 'staging'])) {
            foreach ($this->venueArray as $venueId) {

                \App\Models\BookingPlatform::where('venue_id', $venueId)->update(
                    [
                        'platform_id' => \App\Services\Constant::MOZREST_PLATFORM_ID,
                        'platform_external_id' => '63321092c7bcd30e12aa104b'
                    ]
                );

                \App\Models\Venue::where('id', $venueId)->update(
                    [
                        'booking_platform_id' => \App\Services\Constant::MOZREST_PLATFORM_ID
                    ]
                );
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};
