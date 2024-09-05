<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Booking\PendingBookingAction;
use App\Http\Requests\PendingBookingRequest;
use App\Services\Constant;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class PendingBookingController extends BaseController
{
    public function __construct(protected PendingBookingAction $pendingBookingAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processPendingBooking(int $venueId, PendingBookingRequest $request): array
    {
        $newRequest = PendingBookingRequest::newRequest($venueId, $request->get('partySize'), $request->get('date'));
        $response = $this->pendingBookingAction->handle($newRequest);
        return [
            'result' => [
                'data' => [
                    'id' => $response['internalId'],
                    'bookingId' => !empty($response) ? $response['id'] : null,
                    'holdingTime' => !empty($response) ? $response['holdingTime'] : Constant::FANZO_HOLDING_TIME,
                ],
            ],
        ];
    }
}
