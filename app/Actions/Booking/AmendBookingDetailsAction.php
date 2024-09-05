<?php

declare(strict_types=1);

namespace App\Actions\Booking;

use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Helpers\BookingActionHelper;
use App\Http\Requests\AmendBookingRequest;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\PendingBookingRequest;
use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use App\Notifications\BookingAmendmentNotification;
use App\Services\AccessService\BookingDetailsAccessService;
use App\Services\BookingService;

class AmendBookingDetailsAction
{
    /**
     */
    public function __construct(
        protected BookingDetails $bookingDetails,
        protected BookingDetailsAccessService $accessService,
        protected CreateBookingAction $createBookingAction,
        protected BookingService $bookingService,
        protected SaveBookingAction $saveBookingAction
    ) {
    }

    /**
     * @return mixed[]
     * @throws ActionNotPermittedException
     * @throws \Fanzo\ServiceCommon\Microservice\Exceptions\MicroserviceException
     */
    public function handle(int $id, string $existingBookingId, AmendBookingRequest $request): array
    {
        $existingBooking = $this->bookingDetails->getOneBookingDetailsByBookingId($existingBookingId);
        $message = 'You cannot perform this action. Both supplied internal id and booking id does not match';

        if (!$this->accessService->checkAccessToBookingByIdBookingId($id, $existingBookingId)) {
            throw new ActionNotPermittedException($message);
        }
        $amendBookingPending = $this->createPendingBooking($request, (int) $existingBooking->venue_id);
        $newBookingId = $amendBookingPending->booking_id;

        $postArray = $this->getDataFromExistingBooking($existingBooking);

        $createBookingPostData = CreateBookingRequest::newRequest(null, collect($postArray));
        $amendCreateResponse = $this->amendCreateBooking($createBookingPostData, $newBookingId);

        $createBookingPostData['fixtureName'] = $existingBooking->fixture_name;
        $methodArray = $this->bookingService->prepareDataToSaved(
            $newBookingId,
            $existingBooking->fixture_id ?? null,
            $createBookingPostData,
            $amendCreateResponse['venueId']
        );

        if (empty($amendCreateResponse)) {
            return $amendCreateResponse;
        }

        $this->saveBookingAction->saveBooking(
            $amendCreateResponse,
            $methodArray,
            $request['specialRequest'] ?? $postArray['specialRequest'] ?? null,
        );
        $fullName = $existingBooking->firstname . ' ' . $existingBooking->lastname;
        $existingBooking->notify(new BookingAmendmentNotification(
            BookingActionHelper::formatDataForEmail($id, new BookingDetailsResource($existingBooking))
        ));

        $this->cancelExistingBooking($existingBookingId, $fullName);

        return [
            'result' => [
                'data' => [
                    'id'        => $amendBookingPending->id,
                    'bookingId' => $amendCreateResponse['id'],
                ],
            ],
        ];
    }

    /**
     * @return mixed[]
     */
    public function getDataFromExistingBooking(BookingDetails $booking): array
    {
        return [
            "specialRequest" => $booking->special_requests,
            "contact"        => [
                "firstname" => $booking->firstname,
                "lastname"  => $booking->lastname,
                "email"     => $booking->email,
                "telephone" => $booking->contact_number,
            ],
        ];
    }

    /**
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     */
    public function createPendingBooking(AmendBookingRequest $request, ?int $venueId): BookingDetails
    {
        $amendRequest = PendingBookingRequest::newRequest(
            $venueId,
            (int) $request->get('partySize'),
            $request->get('date')
        );
        $response = $this->bookingService->pendingBooking($amendRequest);
        return BookingDetails::create(
            [
                'booking_id' => $response['id'],
            ]
        );
    }

    /**
     * @param mixed[] $createBookingPostData
     * @return mixed[]
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     */
    public function amendCreateBooking(array $createBookingPostData, string $newBookingId): array
    {
        return $this->bookingService->createBooking($newBookingId, $createBookingPostData);
    }

    /**
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     */
    public function cancelExistingBooking(string $existingBookingId, string $fullName): void
    {
        $cancelExistingBookingServiceResponse = $this->bookingService->cancelBooking($existingBookingId, ['cancelActor' => $fullName]);
        BookingDetails::updateBookingAfterCancel($existingBookingId, $cancelExistingBookingServiceResponse);
    }
}
