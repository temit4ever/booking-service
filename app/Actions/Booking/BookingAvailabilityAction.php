<?php

declare(strict_types=1);

namespace App\Actions\Booking;

use App\Http\Requests\BookingAvailabilityRequest;
use App\Models\BookingPlatform;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class BookingAvailabilityAction
{
    /**
     */
    public function __construct(
        protected BookingService $bookingService,
        protected BookingPlatform $bookingPlatform,
    ) {
    }

    /**
     * @return mixed[]
     * @throws \App\Exceptions\ExternalServiceException\BookingServiceException
     */
    public function handle(BookingAvailabilityRequest $availabilityRequest): array
    {
        if ($this->bookingVenueHasPlatform($availabilityRequest)->isEmpty()) {
            return [
                'result' => ['data' => false],
            ];
        }

        $venueId = (int) $availabilityRequest->get('venueId');
        $platformExternalId = $this->bookingPlatform->getVenuePlatformExternalId($venueId);
        $request = $this->getAvailabilityRequest($platformExternalId, $availabilityRequest);
        $timeWithLeadingZero = Carbon::parse($request['date'])->format('H:i');
        $timeWithoutLeadingZero = Carbon::parse($request['date'])->format('G:i');
        $response = $this->bookingService->bookingAvailability($request);
        if (empty($response)) {
            return ['result' => ['data' => false]];
        }

        $slots = Arr::flatten($response['slots']);
        $openingTime = Arr::flatten($response['openingTimes']);
        $result = false;

        // Check to see if the booking time supplied is within the time slot available and venue opening time.
        if (in_array($timeWithoutLeadingZero, $slots) && in_array($timeWithLeadingZero, $openingTime)) {
            $result = true;
        }
        return ['result' => ['data' => $result]];
    }

    /**
     */
    public function bookingVenueHasPlatform(BookingAvailabilityRequest $request): \Illuminate\Support\Collection
    {
        // Using laravel scope here
        $collection = BookingPlatform::getBookingPlatformByVenueId((int) $request->get('venueId'));
        return $collection->get();
    }

    /**
     * @return mixed[]
     */
    public function getAvailabilityRequest(string $platformExternalId, BookingAvailabilityRequest $request): array
    {
        return [
            'venueId'   => $platformExternalId,
            'date'      => (int) $request->get('date'),
            'partySize' => $request->get('partySize'),
        ];
    }
}
