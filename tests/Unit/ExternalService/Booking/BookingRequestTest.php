<?php
declare(strict_types=1);

namespace Tests\Unit\ExternalService\Booking;

use App\Services\Constant;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use DateTime;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingRequestTest extends TestCase
{

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->pendingUrl = 'pending-booking';
        $this->AvailabilityUrl = 'availability';
        $this->cancelBookingPath = '/cancel';
        $currentYear = now()->format('Y-m-d');
        $time = new DateTime($currentYear);
        $this->timestamp = $time->modify('+16 hours')->getTimestamp();
        $this->token = app()->isProduction() ? config('services.mozrest.prodKey') :
            config('services.mozrest.sandboxKey');
        $this->baseUrl = config('services.mozrest.appUrl');

        $this->data = $this->getPostData();
        $this->pendingData = $this->fetchCommonPayload();
    }

    /**
     * @param $pendingData
     * @return PromiseInterface|Response
     */
    public function getPendingBookingResponseFromExternalService($pendingData): PromiseInterface|Response
    {
        return Http::withHeaders($this->getDefaultHeaders())
            ->post($this->baseUrl . $this->pendingUrl, $pendingData);
    }

    /**
     * @param $data
     * @return PromiseInterface|Response
     */
    public function getCommitBookingResponseFromExternalService($data): PromiseInterface|Response
    {
        $pendingResponse = $this->getPendingBookingResponseFromExternalService($this->pendingData);
        return Http::withHeaders($this->getDefaultHeaders())
            ->put($this->baseUrl . $this->pendingUrl . '/' . $pendingResponse['id'], $data );
    }

    /**
     * @return void
     */
    public function test_missing_mandatory_field_value_from_post_failed_for_commit_booking(): void
    {
        $mandatoryFields = [
            'contact' => [
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'telephone' => '',
                'locale' => '',
                'address' => [
                    'country' => ''
                ]
            ]
        ];

        $response = $this->getCommitBookingResponseFromExternalService($mandatoryFields);
        $this->assertEquals(Constant::BAD_REQUEST, $response->status());
    }

    /**
     * @return void
     */
    public function test_that_commit_booking_was_successful(): void
    {
        $actual = $this->getCommitBookingResponseFromExternalService($this->data);
        $this->assertEquals(Constant::OK, $actual->status());
        $this->assertEquals('confirmed', $actual->json()['status']);
    }

    /**
     * @return void
     */
    public function test_cancel_booking_failed_for_invalid_booking_id(): void
    {
        $url = $this->baseUrl . 'bookings/60e890aca5f07b6ee5b950b1' . $this->cancelBookingPath;
        $response = Http::withHeaders($this->getDefaultHeaders())
            ->put($url, $this->getCancelBookingPayload());
        $this->assertEquals(Constant::NOT_FOUND, $response->status());
    }

    /**
     * @return void
     */
    public function test_cancel_booking_was_created_successfully(): void
    {
        $commitResponse = $this->getCommitBookingResponseFromExternalService($this->data);
        $url = $this->baseUrl . 'booking/' . $commitResponse['id'] . $this->cancelBookingPath;
        $actual = Http::withHeaders($this->getDefaultHeaders())
            ->put($url, $this->getCancelBookingPayload());
        $this->assertEquals(Constant::OK, $actual->status());
        $this->assertEquals('canceled', $actual->json()['status']);
    }

    /**
     * @return string[]
     */
    public function getCancelBookingPayload(): array
    {
        return [
            'cancelActor'  => 'Test user',
            'cancelReason' => 'Test cancel',
        ];
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return [
            "notes" => "Gluten free",
            "contact" => [
                "firstname" => "John",
                "lastname" => "Doe",
                "email" => "john.doe@gmail.com",
                "telephone" => "44344223322",
                "locale" => "en",
                'address' => [
                    'country' => 'GB'
                ]
            ]
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
}
