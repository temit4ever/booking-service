<?php

declare(strict_types=1);

namespace App\Actions\AppBooking;

use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use Carbon\Carbon;
use Fanzo\ServiceCommon\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AppPastBookingDetailsAction
{
    /**
     * @return mixed[]
     */
    public function handle(int $limit, int $offset): ?array
    {
        $memberId = Auth::user() instanceof User ? Auth::user()->getAuthIdentifier() : null;
        return [
            'result' => [
                'data' => $this->getPastBooking($memberId, $limit, $offset),
            ],
        ];
    }

    /**
     */
    public function getPastBooking(?int $memberId, int $limit, int $offset): AnonymousResourceCollection
    {
        $booking = BookingDetails::getBookingDetailsByMemberId($memberId);

        return BookingDetailsResource::collection($booking
            ->whereDate('book_date_time', '<', Carbon::now())
            ->orderBy('book_date_time')
            ->latest()
            ->limit(!empty($limit) ? $limit : 3)
            ->offset($offset)
            ->get());
    }
}
