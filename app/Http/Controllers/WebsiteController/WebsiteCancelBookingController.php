<?php

declare(strict_types=1);

namespace App\Http\Controllers\WebsiteController;

use App\Actions\WebsiteBooking\WebsiteCancelBookingAction;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class WebsiteCancelBookingController extends BaseController
{
    public function __construct(protected WebsiteCancelBookingAction $cancelBookingAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processCancelBooking(int $id, string $bookingId): array
    {
        $this->cancelBookingAction->handle($id, $bookingId);
        return $this->getSuccessResponse('Booking was successfully cancelled');
    }
}
