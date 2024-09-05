<?php

declare(strict_types=1);

namespace App\Actions\AppBooking;

use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use Carbon\Carbon;
use Fanzo\ServiceCommon\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AppUpcomingBookingDetailsAction
{
    /**
     * @return mixed[]
     */
    public function handle(): ?array
    {
        $memberId = Auth::user() instanceof User ? Auth::user()->getAuthIdentifier() : null;

        return [
            'result' => [
                'data' => $this->getUpcomingBooking($memberId),
            ],
        ];
    }

    /**
     */
    public function getUpcomingBooking(?int $memberId): AnonymousResourceCollection
    {
        $booking = BookingDetails::getBookingDetailsByMemberId($memberId);
        return BookingDetailsResource::collection($booking
            ->whereDate('book_date_time', '>=', Carbon::now())
            ->orderBy('book_date_time')
            ->latest()
            ->get());
    }
}
