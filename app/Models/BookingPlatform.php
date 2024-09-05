<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Constant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingPlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'platform_id',
        'platform_external_id',
        'active',
    ];

    /**
     *  Get collection from booking platform table based on the platform external id.
     *
     */
    public function scopeGetBookingPlatformByPlatformExternalId(Builder $query, string $arg): Builder
    {
        return $query->where([
            'platform_external_id' => $arg,
            'platform_id' => Constant::MOZREST_PLATFORM_ID,
        ]);
    }
    /**
     *  Get collection from booking platform table based on the venue id.
     *
     */
    public function scopeGetBookingPlatformByVenueId(Builder $query, ?int $arg): Builder
    {
        return $query->where([
            'venue_id' => $arg,
            'platform_id' => Constant::MOZREST_PLATFORM_ID,
        ]);
    }

    /**
     */
    public function getVenuePlatformExternalId(?int $venueId): string
    {
        // Using laravel scope here
        $query = BookingPlatform::getBookingPlatformByVenueId($venueId);
        $bookingPlatform = $query->get();
        if ($bookingPlatform->isEmpty()) {
            throw new ModelNotFoundException("No booking platform found for the supplied venue id - {$venueId}");
        }

        return  $bookingPlatform->pluck('platform_external_id')[0];
    }
}
