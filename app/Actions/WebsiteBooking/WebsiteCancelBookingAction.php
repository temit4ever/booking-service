<?php

declare(strict_types=1);

namespace App\Actions\WebsiteBooking;

use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Helpers\BookingActionHelper;
use App\Http\Requests\CancelBookingRequest;
use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use App\Notifications\BookingCancellationNotification;
use App\Services\AccessService\BookingDetailsAccessService;
use App\Services\BookingService;

class WebsiteCancelBookingAction
{
    /**
     */
    public function __construct(
        protected BookingService $bookingService,
        protected BookingDetailsAccessService $service,
        protected BookingDetails $bookingDetails
    ) {
    }

    /**
     * @return mixed[]
     * @throws ActionNotPermittedException
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     * @throws \Fanzo\ServiceCommon\Microservice\Exceptions\MicroserviceException
     */
    public function handle(int $id, string $bookingId): array
    {
        $message = 'You cannot perform this action because the supplied booking id and Id does not match';

        if (!$this->service->checkAccessToBookingByIdBookingId($id, $bookingId)) {
            throw new ActionNotPermittedException($message);
        }

        $queryBookingId = $this->bookingDetails->getRecordByBookingId($bookingId);
        $bookingDetails = $queryBookingId->first();

        $response = $this->bookingService->cancelBooking($bookingId, CancelBookingRequest::newRequest($bookingDetails));
        if (empty($response)) {
            return [
                'result' => ['message' => 'No record was found'],
            ];
        }
        // Using laravel scope here
        BookingDetails::updateBookingAfterCancel($bookingId, $response);

        if (!is_null($bookingDetails)) {
            $bookingDetails->notify(new BookingCancellationNotification(
                BookingActionHelper::formatDataForEmail($id, new BookingDetailsResource($bookingDetails))
            ));
        }

        return $response;
    }

    /**
     */
    public function updateBooking(string $bookingId, string $status): void
    {
        BookingDetails::where('booking_id', $bookingId)
            ->update(['status' => $status]);
    }
}
