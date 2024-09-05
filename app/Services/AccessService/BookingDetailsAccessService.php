<?php

declare(strict_types=1);

namespace App\Services\AccessService;

use App\Models\BookingDetails;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingDetailsAccessService
{
    public function __construct(protected BookingDetails $bookingDetails)
    {
    }

    public function checkAccessToBookingByIdBookingId(int $id, string $bookingId): bool
    {
        // Using laravel scope here
        $query = BookingDetails::getRecordById($id);
        $details = $query->get();
        $collection = $query->first();

        if ($details->isEmpty()) {
            throw new ModelNotFoundException("No record found for the supplied id - {$id}");
        }

        return $collection?->booking_id === $bookingId;
    }

    public function checkAccessToBookingByBookingId(string $bookingId): bool
    {
        // Using laravel scope here
        $query = BookingDetails::getRecordByBookingId($bookingId);

        $details = $query->get();
        if ($details->isEmpty()) {
            return false;
        }

        return true;
    }

    public function checkAccessToBookingByMemberId(?int $memberId): bool
    {
        // Using laravel scope here
        $query = BookingDetails::getBookingDetailsByMemberId($memberId);
        $details = $query->get();
        if ($details->isEmpty()) {
            return false;
        }

        return true;
    }

    public function checkAccessToBookingByVenueIdBookingId(int $venueId, string $bookingId): bool
    {
        // Using laravel scope here
        $query = BookingDetails::getBookingDetailsByVenueIdBookingId($venueId, $bookingId);
        $details = $query->get();
        if ($details->isEmpty()) {
            return false;
        }

        return true;
    }

    public function checkAccessToBookingByMemberIdBookingId(string $bookingId, int $memberId): bool
    {
        // Using laravel scope here
        $query = $this->bookingDetails->getRecordByBookingId($bookingId);

        $details = $query->get();
        $collection = $query->first();

        if ($details->isEmpty()) {
            throw new ModelNotFoundException("No record found for the supplied id - {$memberId}");
        }

        return $collection?->member_id === $memberId;
    }
}
