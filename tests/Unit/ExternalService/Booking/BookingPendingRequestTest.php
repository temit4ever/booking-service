<?php

namespace Tests\Unit\ExternalService\Booking;

use App\Services\Constant;
use DateTime;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingPendingRequestTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->pendingUrl = 'pending-booking';
        $this->token = app()->isProduction() ? config('services.mozrest.prodKey') :
            config('services.mozrest.sandboxKey');
        $this->baseUrl = config('services.mozrest.appUrl');
        $currentYear = now()->format('Y-m-d');
        $time = new DateTime($currentYear);
        $this->timestamp = $time->modify('+16 hours')->getTimestamp();
        $this->commomPayload = $this->fetchCommonPayload();
    }

    /**
     * @param $data
     * @return PromiseInterface|Response
     */
    public function getPendingResponseFromExternalService($data): PromiseInterface|Response
    {
        return Http::withHeaders($this->getDefaultHeaders())
            ->post($this->baseUrl . $this->pendingUrl, $data);
    }

    /**
     * @return void
     */
    public function test_pending_booking_request_failed_for_missing_date(): void
    {
        $query = $this->commomPayload;
        unset($query['date']);
        $response = $this->getPendingResponseFromExternalService($query);
        $this->assertEquals(Constant::BAD_REQUEST, $response->status());
    }

    /**
     * @return void
     */
    public function test_pending_booking_request_failed_for_missing_guest_number(): void
    {
        $query = $this->commomPayload;
        unset($query['partySize']);
        $response = $this->getPendingResponseFromExternalService($query);
        $this->assertEquals(Constant::BAD_REQUEST, $response->status());
    }

    /**
     * @return void
     */
    public function test_pending_booking_request_failed_for_missing_venue_id(): void
    {
        $query = $this->commomPayload;
        unset($query['venueId']);
        $response = $this->getPendingResponseFromExternalService($query);
        $this->assertEquals(Constant::BAD_REQUEST, $response->status());
    }

    /**
     * @return void
     */
    public function test_pending_booking_request_failed_for_invalid_venue_id(): void
    {
        $query = $this->commomPayload;
        $query['venueId'] = '63321092c7bcd30e12aa104b890';
        $response = $this->getPendingResponseFromExternalService($query);
        $this->assertEquals(Constant::BAD_REQUEST, $response->status());
    }

    /**
     * @return void
     */
    public function test_that_pending_booking_call_was_successful(): void
    {
        $query = $this->commomPayload;
        $actual = $this->getPendingResponseFromExternalService($query);
        $this->assertEquals(Constant::OK, $actual->status());
        $this->assertIsArray($actual->json());
        $this->assertNotEmpty($actual->json());
        $this->assertEquals(420, $actual->json()['holdingTime']);
    }

    /**
     * @return array
     */
    public function fetchCommonPayload(): array
    {
        return [
            'venueId' => '63321092c7bcd30e12aa104b',
            'partySize' => 4,
            'date' => $this->timestamp,
        ];
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
}
