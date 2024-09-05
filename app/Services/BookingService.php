<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ExternalServiceException\BookingServiceException;
use App\Models\BookingPlatform;
use Exception;
use Illuminate\Support\Facades\Http;

class BookingService
{
    protected string $cancelBookingPath = '/cancel';
    protected string $bookingPath = 'booking';
    protected string $availabilityPath = 'availability';
    protected string $pendingBookingPath = 'pending-booking';

    public function __construct(
        protected string $baseUrlAuth,
        protected string $token,
        protected string $timeout,
        protected string $retry,
    ) {
    }

    /**
     *@param mixed[] $request
     * @return mixed[]
     * @throws BookingServiceException
     */
    public function pendingBooking(array $request): array
    {
        try {
            $response = Http::withHeaders($this->setHeader())
                ->retry((int) $this->retry)
                ->timeout((int) $this->timeout)
                ->baseUrl($this->baseUrlAuth)
                ->post($this->pendingBookingPath, $request)
                ->json();
        } catch (Exception $ex) {
            throw new BookingServiceException($ex->getMessage(), $ex->getCode());
        }

        if (empty($response)) {
            return [];
        }

        return $response;
    }


    /**
     * @param mixed[] $request
     * @return mixed[]
     * @throws BookingServiceException
     */
    public function cancelBooking(string $bookingId, array $request): array
    {
        $url = $this->bookingPath . '/' . $bookingId . $this->cancelBookingPath;
        return $this->extracted($url, $request);
    }

    /**
     * @param mixed[] $request
     * @return mixed[]
     * @throws BookingServiceException
     */
    public function createBooking(string $bookingId, array $request): array
    {
        $url = $this->pendingBookingPath . '/' . $bookingId;
        return $this->extracted($url, $request);
    }

    /**
     * @param mixed[] $request
     * @return mixed[]
     * @throws BookingServiceException
     */
    public function bookingAvailability(array $request): array
    {
        try {
            $response = Http::withHeaders($this->setHeader())
                ->retry((int) $this->retry)
                ->timeout((int) $this->timeout)
                ->baseUrl($this->baseUrlAuth)
                ->get($this->availabilityPath, $request)
                ->json();
        } catch (Exception $ex) {
            throw new BookingServiceException($ex->getMessage(), $ex->getCode());
        }

        if (empty($response)) {
            return [];
        }

        return $response;
    }

    /**
     * @return mixed[]
     */
    public function setHeader(): array
    {
        return [
            'Accept'         => 'application/json',
            'Content-Type'   => 'application/json',
            'Content-Length' => 0,
            'Authorization'  => ' Bearer ' . $this->token,
        ];
    }

    /**
     * @param mixed[] $request
     * @return mixed[]
     * @throws BookingServiceException
     */
    public function extracted(string $url, array $request): mixed
    {
        try {
            $response = Http::withHeaders($this->setHeader())
                ->retry((int)$this->retry)
                ->timeout((int)$this->timeout)
                ->baseUrl($this->baseUrlAuth)
                ->put($url, $request)
                ->json();
        } catch (Exception $ex) {
            throw new BookingServiceException($ex->getMessage(), $ex->getCode());
        }

        if (empty($response)) {
            return [];
        }

        return $response;
    }

    /**
     * @param mixed[] $postRequest
     * @return mixed[]
     */
    public function prepareDataToSaved(
        string $bookingId,
        ?int $fixtureId,
        array $postRequest,
        string $externalVenueId
    ): array {
        // Using laravel scope here
        $collection = BookingPlatform::getBookingPlatformByPlatformExternalId($externalVenueId);
        $collection = $collection->first();
        $venueId = $collection->venue_id ?? null;

        return  [
            'venueId'        => $venueId,
            'fixtureId'      => $fixtureId,
            'bookingId'      => $bookingId,
            'firstname'      => $postRequest['contact']['firstname'],
            'lastname'       => $postRequest['contact']['lastname'],
            'email'          => $postRequest['contact']['email'],
            'telephone'      => $postRequest['contact']['telephone'],
            'locale'         => $postRequest['contact']['locale'],
            'address'        => $postRequest['contact']['address']['country'],
            'specialRequest' => $postRequest['notes'],
            'name'           => $postRequest['fixtureName'],
        ];
    }
}
