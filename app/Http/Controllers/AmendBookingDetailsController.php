<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Booking\AmendBookingDetailsAction;
use App\Http\Requests\AmendBookingRequest;
use App\Services\Constant;
use Fanzo\ServiceCommon\Http\Controllers\BaseController;

class AmendBookingDetailsController extends BaseController
{
    public function __construct(protected AmendBookingDetailsAction $amendBookingDetailsAction)
    {
    }

    /**
     * @return mixed[]
     */
    public function processAmendBookingDetails(int $id, string $bookingId, AmendBookingRequest $request): array
    {
        $result = $this->amendBookingDetailsAction->handle($id, $bookingId, $request);

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
