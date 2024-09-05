<?php

declare(strict_types=1);

namespace App\Http\Controllers\WebsiteController;

use App\Actions\WebsiteBooking\WebsiteBookingDetailsAction;
use App\Http\Requests\BookingDetailsRequest;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class WebsiteBookingDetailsController extends BaseController
{
    public function __construct(protected WebsiteBookingDetailsAction $bookingDetailsAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processBookingDetails(BookingDetailsRequest $bookingDetailsRequest): ?array
    {
        return $this->bookingDetailsAction->handle($bookingDetailsRequest);
    }
}
