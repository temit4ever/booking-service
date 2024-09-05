<?php

namespace Tests\Unit\ExternalService\Booking;

use App\Services\Constant;
use DateTime;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingAvailabilityTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->availabilityUrl = 'availability';
        $currentYear = now()->format('Y-m-d');
        $time = new DateTime($currentYear);
        $this->timestamp = $time->modify('+16 hours')->getTimestamp();
        $this->token = app()->isProduction() ? config('services.mozrest.prodKey') :
            config('services.mozrest.sandboxKey');
        $this->baseUrl = config('services.mozrest.appUrl');
        $this->data = $this->fetchAvailabilityPayload();
    }

    /**
     * @param $data
     * @return PromiseInterface|Response
     */
    public function getAvailabilityResponseFromExternalService($data): PromiseInterface|Response
    {
        return Http::withHeaders($this->getDefaultHeaders())
            ->get($this->baseUrl . $this->availabilityUrl, $data);
    }

    /**
     * @return void
     */
    public function test_access_token_supply_is_invalid(): void
    {
        $header = $this->getDefaultHeaders();
        $header = array_replace($header, ['Authorization' => 'Bearer 12345test']);
        $response = Http::withHeaders($header)->get($this->baseUrl . $this->availabilityUrl, $this->data);
        $this->assertEquals(Constant::UNAUTHORIZED, $response->status());
    }

    /**
     * @return void
     */
    public function test_booking_availability_get_request_failed_for_missing_date(): void
    {
        $query = $this->data;
        unset($query['date']);
        $response = $this->getAvailabilityResponseFromExternalService($query);

        $this->assertEquals(Constant::NOT_FOUND, $response->status());
    }

    /**
     * @return void
     */
    public function test_booking_availability_get_request_failed_for_missing_venue_id(): void
    {
        $query = $this->data;
        unset($query['venueId']);
        $response = $this->getAvailabilityResponseFromExternalService($query);
        $this->assertEquals(Constant::NOT_FOUND, $response->status());
    }

    /**
     * @return void
     */
    public function test_booking_availability_get_request_failed_for_missing_guest_number(): void
    {
        $query = $this->data;
        unset($query['partySize']);
        $response = $this->getAvailabilityResponseFromExternalService($query);
        $this->assertEquals(Constant::NOT_FOUND, $response->status());
    }

    /**
     * @return void
     */
    public function test_booking_availability_get_request_was_successful(): void
    {
        $response = $this->getAvailabilityResponseFromExternalService($this->data);
        $this->assertEquals(Constant::OK, $response->status());
        $this->assertIsArray($response->json());
        $this->assertNotEmpty($response->json());
    }

    /**
     * @return array
     */
    public function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Content-Length' => 0,
            'Authorization' => ' Bearer ' . $this->token
        ];
    }

    /**
     * @return array
     */
    public function fetchAvailabilityPayload(): array
    {
        return [
            'venueId' => '63321092c7bcd30e12aa104b',
            'partySize' => 4,
            'date' => $this->timestamp,
        ];
    }
}
