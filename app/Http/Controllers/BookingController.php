<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Booking\CreateBookingAction;
use App\Http\Requests\CreateBookingRequest;
use App\Services\Constant;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class BookingController extends BaseController
{
    public function __construct(protected CreateBookingAction $bookingAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processCommitPendingBooking(string $bookingId, CreateBookingRequest $request): array
    {
        $result = $this->bookingAction->handle($bookingId, $request);

        if (empty($result)) {
            return [
                'result' => [
                    'message' => 'The requested item was not found',
                    'statusCode' => Constant::NOT_FOUND,
                ],
            ];
        }

        return $result;
    }
}
