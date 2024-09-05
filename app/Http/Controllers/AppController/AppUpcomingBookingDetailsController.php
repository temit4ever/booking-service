<?php

declare(strict_types=1);

namespace App\Http\Controllers\AppController;

use App\Actions\AppBooking\AppUpcomingBookingDetailsAction;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class AppUpcomingBookingDetailsController extends BaseController
{
    public function __construct(protected AppUpcomingBookingDetailsAction $bookingDetails)
    {
    }

    /**
     * @return mixed[]
     */
    public function processUpcomingBookingDetails(): ?array
    {
        return $this->bookingDetails->handle();
    }
}
