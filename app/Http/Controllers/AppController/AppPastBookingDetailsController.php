<?php

declare(strict_types=1);

namespace App\Http\Controllers\AppController;

use App\Actions\AppBooking\AppPastBookingDetailsAction;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AppPastBookingDetailsController extends BaseController
{
    public function __construct(protected AppPastBookingDetailsAction $bookingDetails)
    {
    }

    /**
     * @return mixed[]
     */
    public function processPastBookingDetails(Request $request): ?array
    {
        return $this->bookingDetails->handle((int) $request->get('limit'), (int) $request->get('offset'));
    }
}
