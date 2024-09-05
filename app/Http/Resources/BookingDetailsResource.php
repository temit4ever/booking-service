<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingDetailsResource extends JsonResource
{
    /**
     * @return mixed[]
     */
    public function toArray(Request $request): array
    {
        $dateTime = $this->book_date_time ?? null;
        return [
            'id'                     =>  $this->id ?? null,
            'venueId'                => $this->venue_id ?? null,
            'fixtureId'               => !empty($this->fixture_id) ? $this->fixture_id : null,
            'venueBookingPlatformId' => $this->venue_booking_platform_id ?? null,
            'memberId'               => $this->member_id ?? null,
            'firstname'               => $this->firstname ?? null,
            'lastname'               => $this->lastname ?? null,
            'email'                  => $this->email ?? null,
            'status'                 => $this->status ?? null,
            'contactNumber'          => $this->contact_number ?? null,
            'numberOfGuest'          => $this->number_of_guest ?? null,
            'bookDateTime'           => !empty($dateTime) ? strtotime($dateTime) : null,
            'fixtureName'             => $this->fixture_name ?? null,
            'specialRequests'        => $this->special_requests ?? null,
            'bookingId'              => $this->booking_id ?? null,
            'deletedAt'              => $this->deleted_at ?? null,
            'createdAt'              => $this->created_at ?? null,
            'updatedAt'              => $this->updated_at ?? null,
        ];
    }
}
