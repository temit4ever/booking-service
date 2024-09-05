<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Booking\BookingAvailabilityAction;
use App\Http\Requests\BookingAvailabilityRequest;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class BookingAvailabilityController extends BaseController
{
    public function __construct(protected BookingAvailabilityAction $bookingAvailabilityAction)
    {
    }


    /**
     * @return mixed[]
     */
    public function processBookingAvailability(BookingAvailabilityRequest $availabilityRequest): array
    {
        return $this->bookingAvailabilityAction->handle($availabilityRequest);
    }
}
