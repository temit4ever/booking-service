<?php
declare(strict_types=1);

namespace Tests\Feature\Booking;


use App\Actions\Booking\SaveBookingAction;
use App\Models\BookingDetails;
use App\Services\Constant;
use DateTime;
use Tests\TestCase;

use \AllowDynamicProperties;

#[AllowDynamicProperties]
class SaveBookingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->fixtureId = 1764;
        $this->venueId = 158;
        $this->fixtureName = 'Bulldogs vs Cronulla - Sutherland Sharks';
        $date = new DateTime();
        $this->dateTime = $date->setTimestamp(1681635411);
        $this->mock = \Mockery::mock(SaveBookingAction::class);
        $this->data = $this->getData();
        $this->booking = BookingDetails::create(
            [
                'booking_id' => '645c1d525d49ff37e78653e2',
            ]
        );

        $this->methodArray = $this->fetchMethodArray();
    }

    /**
     * @return void
     */
    public function test_that_response_from_api_save_successfully_with_fixtureId(): void
    {
        $actual = app(SaveBookingAction::class)->saveBooking($this->data, $this->methodArray);
        $this->mock
            ->shouldReceive('saveBooking')
            ->once()
            ->with($this->data, $this->methodArray )
            ->andReturn(true);

        $expected = $this->mock->saveBooking($this->data, $this->methodArray);
        $this->assertTrue($expected);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'email' => 'jane.doe@test.com',
            'booking_id' => '643bb48a2bd4f6d68371f15c'
        ]);
        $this->assertModelExists($this->booking);
    }


    /**
     * @return void
     */
    public function test_that_response_from_api_save_successfully_without_fixtureId(): void
    {
        $methodArray = $this->methodArray;
        unset($methodArray['name']);
        $actual = app(SaveBookingAction::class)->saveBooking($this->data, $methodArray);
        $this->mock->shouldReceive('saveBooking')
            ->withSomeOfArgs($this->data, $methodArray)
            ->andReturn(true);

        $expected = $this->mock->saveBooking($this->data, $methodArray);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'email' => 'jane.doe@test.com',
            'number_of_guest' => 2,
            'booking_id' => '643bb48a2bd4f6d68371f15c'

        ]);
        $this->assertModelExists($this->booking);
    }

    public function getData(): array
    {
        return [
            "id" => "643bb48a2bd4f6d68371f15c",
            'venueId' => '63321092c7bcd30e12aa104b',
            "partySize" => 2,
            "date" => $this->dateTime,
            "status" => "pending",
        ];
    }

    public function fetchMethodArray(): array
    {
        return [
            'venueId' => $this->venueId,
            'fixtureId' => $this->fixtureId,
            'bookingId' => '645c1d525d49ff37e78653e2',
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane.doe@test.com',
            'telephone' => 4457777777,
            'specialRequest' => "Gluten free" . PHP_EOL .  $this->fixtureName . PHP_EOL . Constant::FANZO_BOOKING_TEXT,
            'name' => $this->fixtureName,
        ];
    }

}
