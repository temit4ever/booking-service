<?php

declare(strict_types=1);

namespace App\Actions\Booking;

use App\Models\BookingDetails;
use Carbon\Carbon;
use Fanzo\ServiceCommon\Models\User;
use Illuminate\Support\Facades\Auth;

class SaveBookingAction
{
    /**
     * @param mixed[] $data
     * @param mixed[] $array
     * @param string|null $specialRequest
     */
    public function saveBooking(array $data, array $array, string $specialRequest = null): bool
    {
        $affectedRow = 0;
        $record = BookingDetails::getRecordByBookingId($array['bookingId']);
        $collection = $record->get();

        if ($collection->isNotEmpty()) {
            $affectedRow = $record->update([
                'venue_id'                  => $array['venueId'],
                'fixture_id'                => $array['fixtureId'],
                'venue_booking_platform_id' => !empty($data['venueId']) ? $data['venueId'] : null,
                'member_id'                 => Auth::user() instanceof User ? Auth::user()->getAuthIdentifier() : null,
                'firstname'                 => $array['firstname'],
                'lastname'                  => $array['lastname'],
                'email'                     => $array['email'],
                'contact_number'            => !empty($array['telephone']) ? $array['telephone'] : null,
                'fixture_name'              => !empty($array['name']) ? $array['name'] : null,
                'status'                    => !empty($data['status']) ? $data['status'] : 'pending',
                'special_requests'          => $specialRequest,
                'number_of_guest'           => !empty($data['partySize']) ? $data['partySize'] : null,
                'book_date_time'            => !empty($data['date']) ? Carbon::parse($data['date'])->format('Y-m-d H:i:s') : null,
                'booking_id'                => !empty($data['id']) ? $data['id'] : null,
            ]);
        }
        return (bool) $affectedRow;
    }
}
