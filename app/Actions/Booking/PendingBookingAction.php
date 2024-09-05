<?php

declare(strict_types=1);

namespace App\Actions\Booking;

use App\Models\BookingDetails;
use App\Services\BookingService;

class PendingBookingAction
{
    /**
     */
    public function __construct(
        protected BookingService $bookingService,
        protected SaveBookingAction $savePendingBooking,
    ) {
    }

    /**
     * @param  mixed[] $request
     * @return mixed[]
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     */
    public function handle(array $request): array
    {
        $response = $this->bookingService->pendingBooking($request);
        $data = null;
        if (!empty($response)) {
            $data = BookingDetails::create(
                [
                    'booking_id' => $response['id'],
                ]
            );
        }
        $response['internalId'] = $data?->id;
        return $response;
    }
}
