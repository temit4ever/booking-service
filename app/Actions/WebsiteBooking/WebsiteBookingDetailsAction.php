<?php

declare(strict_types=1);

namespace App\Actions\WebsiteBooking;

use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Http\Requests\BookingDetailsRequest;
use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use App\Services\AccessService\BookingDetailsAccessService;

class WebsiteBookingDetailsAction
{
    /**
     */
    public function __construct(protected BookingDetails $bookingDetails)
    {
    }

    /**
     * @return mixed[]
     * @throws ActionNotPermittedException
     */
    public function handle(BookingDetailsRequest $request): ?array
    {
        $grantPermission = new BookingDetailsAccessService($this->bookingDetails);
        $id = (int) $request->id;
        $bookingId = $request->bookingId;

        if (!$grantPermission->checkAccessToBookingByIdBookingId($id, $bookingId)) {
            throw new ActionNotPermittedException('You cannot perform this action');
        }

        $booking = BookingDetails::getBookingDetailsByIdAndBookingId($id, $bookingId);
        return [
            'result' => ['data' => BookingDetailsResource::collection($booking->get())],
        ];
    }
}
