<?php

declare(strict_types=1);

namespace App\Actions\AppBooking;

use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Http\Requests\CancelBookingRequest;
use App\Models\BookingDetails;
use App\Services\AccessService\BookingDetailsAccessService;
use App\Services\BookingService;
use Fanzo\ServiceCommon\Models\User;
use Illuminate\Support\Facades\Auth;

class AppCancelBookingAction
{
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
     */
    public function handle(string $bookingId): array
    {
        $memberId = Auth::user() instanceof User ? Auth::user()->getAuthIdentifier() : null;

        // Using laravel scope here
        $queryBookingId = $this->bookingDetails->getRecordByBookingId($bookingId);
        $bookingDetails = $queryBookingId->first();
        $message = 'You cannot perform this action because the supplied booking id does not belong to this member';

        if (!$this->service->checkAccessToBookingByMemberIdBookingId($bookingId, $memberId)) {
            throw new ActionNotPermittedException($message);
        }

        $response = $this->bookingService->cancelBooking($bookingId, CancelBookingRequest::newRequest($bookingDetails));
        if (empty($response)) {
            return [
                'result' => [
                    'message' => 'No record was found',
                ],
            ];
        }

        // Using laravel scope here
        $this->bookingDetails->updateBookingAfterCancel($bookingId, $response);

        return $response;
    }

    /**
     */
    public function updateBooking(string $bookingId, string $status): void
    {
        $this->bookingDetails->where('booking_id', $bookingId)
            ->update(['status' => $status]);
    }
}
