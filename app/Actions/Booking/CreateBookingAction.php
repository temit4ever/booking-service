<?php

declare(strict_types=1);

namespace App\Actions\Booking;

use App\Exceptions\GeneralException\ActionNotPermittedException;
use App\Helpers\BookingActionHelper;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingDetailsResource;
use App\Models\BookingDetails;
use App\Models\Events;
use App\Notifications\BookingConfirmationNotification;
use App\Services\AccessService\BookingDetailsAccessService;
use App\Services\BookingService;

class CreateBookingAction
{
    /**
     */
    public function __construct(
        protected BookingService $bookingService,
        protected SaveBookingAction $saveAction,
        protected BookingDetailsAccessService $service,
    ) {
    }

    /**
     * @return mixed[]
     * @throws ActionNotPermittedException
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     * @throws \Fanzo\ServiceCommon\Microservice\Exceptions\MicroserviceException
     */
    public function handle(string $bookingId, CreateBookingRequest $request): array
    {
        if (!$this->service->checkAccessToBookingByBookingId($bookingId)) {
            throw new ActionNotPermittedException('You cannot perform this action');
        }

        $booking = BookingDetails::getRecordByBookingId($bookingId)->firstOrFail();
        $id = $booking->id;
        $fixtureId = (int) $request['fixtureId'];
        $eventQuery = Events::getFixtureById($fixtureId);
        $fixtureName = $eventQuery->first()->event_name ?? null;
        $postRequest = CreateBookingRequest::newRequest($fixtureName, collect($request));
        $response = $this->bookingService->createBooking($bookingId, $postRequest);
        $postRequest['fixtureName'] = $fixtureName;
        $methodArray = $this->bookingService->prepareDataToSaved(
            $bookingId,
            !empty($fixtureId) ? $fixtureId : null,
            $postRequest,
            $response['venueId'],
        );

        if (empty($response)) {
            return $response;
        }
        $this->saveAction->saveBooking($response, $methodArray, $request['specialRequest']);
        $newBooking = BookingDetails::getRecordById($id)->firstOrFail();
        $newBooking->notify(new BookingConfirmationNotification(
            BookingActionHelper::formatDataForEmail($id, new BookingDetailsResource($newBooking))
        ));
        return [
            'result' => [
                'data' => [
                    'id'        => $id,
                    'bookingId' => $response['id'],
                ],
            ],


        ];
    }
}
