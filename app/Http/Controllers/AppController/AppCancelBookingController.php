<?php

declare(strict_types=1);

namespace App\Http\Controllers\AppController;

use App\Actions\AppBooking\AppCancelBookingAction;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class AppCancelBookingController extends BaseController
{
    public function __construct(protected AppCancelBookingAction $cancelBookingAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processCancelBooking(string $bookingId): array
    {
        $this->cancelBookingAction->handle($bookingId);
        return $this->getSuccessResponse('Booking was successfully cancelled');
    }
}
