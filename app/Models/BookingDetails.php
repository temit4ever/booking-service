<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class BookingDetails extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'venue_id',
        'member_id',
        'firstname',
        'lastname',
        'email',
        'status',
        'contact_number',
        'number_of_guest',
        'book_date_time',
        'fixture_name',
        'special_requests',
        'booking_id',
    ];

    public function venue(): hasOne
    {
        return $this->hasOne(Venue::class, 'id', 'venue_id');
    }

    public function events(): hasOne
    {
        return $this->hasOne(Events::class, 'id', 'fixture_id');
    }

    /**
     * Get the booking details collection based on the primary id from the table
     *
     * @param $query
     * @param $arg
     */
    public function scopeGetRecordById(Builder $query, int $arg): Builder
    {
        return $query->where('id', $arg);
    }

    /**
     * Get the booking details collection based on the booking id from the table
     *
     * @param $query
     * @param $arg
     */
    public function scopeGetRecordByBookingId(Builder $query, string $arg): Builder
    {
        return $query->where('booking_id', $arg);
    }

    /**
     * Perform update on the booking details table base on the booking id.
     * @param $query
     * @param $arg
     * @param mixed[] $response
     */
    public function scopeUpdateBookingAfterCancel(Builder $query, string $bookingId, array $response): void
    {
        $query->where('booking_id', $bookingId)
            ->update(
                [
                    'status' => $response['status'],
                    'deleted_at' => Carbon::now(),
                ]
            );
    }

    /**
     * Retrieve the booking details base on the id and platform booking id.
     * @param $query
     * @param $id
     * @param $bookingId
     */
    public function scopeGetBookingDetailsByIdAndBookingId(Builder $query, int $id, string $bookingId): Builder
    {
        return $query->where([
            'id' => $id,
            'booking_id' => $bookingId,
        ]);
    }

    /**
     * Retrieve the booking details base on the id and platform booking id.
     */
    public function scopeGetBookingDetailsByMemberId(Builder $query, ?int $memberId): Builder
    {
        return $query->where([
            'member_id' => $memberId,
        ]);
    }

    /**
     * Retrieve the booking details base on the venue & booking id.
     */
    public function scopeGetBookingDetailsByVenueIdBookingId(Builder $query, ?int $venueId, string $bookingId): Builder
    {
        return $query->where([
            'venue_id' => $venueId,
            'booking_id' => $bookingId,
        ]);
    }

    /**
     */
    public function getOneBookingDetailsByBookingId(string $bookingId): mixed
    {
        // Using laravel scope here
        $queryBuilder = BookingDetails::getRecordByBookingId($bookingId);
        $result = $queryBuilder->get();
        if ($result->isEmpty()) {
            throw new ModelNotFoundException("No record found for the supplied booking id - {$bookingId}");
        }

        return  $result->first() ?? null;
    }
}
