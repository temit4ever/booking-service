<?php

namespace Tests\Feature\Booking;

use App\Models\BookingDetails;
use App\Services\AccessService\BookingDetailsAccessService;

use Tests\TestCase;

class BookingDetailsAccessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->mock = \Mockery::mock(BookingDetailsAccessService::class);

        $this->booking = BookingDetails::create(
            [
                'booking_id' => '645c1d525d49ff37e78653e2',
                'member_id' => 1,
                'venue_id' => 30,
            ]
        );
    }

    public function test_can_access_booking_by_id_and_booking_id(): void
    {
        $actual = app(BookingDetailsAccessService::class)->checkAccessToBookingByIdBookingId(
            $this->booking->id,
            $this->booking->booking_id
        );

        $this->mock
            ->shouldReceive('checkAccessToBookingByIdBookingId')
            ->once()
            ->with($this->booking->id, $this->booking->booking_id)
            ->andReturn(true);

        $expected = $this->mock->checkAccessToBookingByIdBookingId($this->booking->id, $this->booking->booking_id);
        $this->assertTrue($expected);
        $this->assertModelExists($this->booking);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'booking_id' => '645c1d525d49ff37e78653e2'
        ]);
    }

    public function test_can_access_booking_by_booking_id(): void
    {
        $actual = app(BookingDetailsAccessService::class)->checkAccessToBookingByBookingId(
            $this->booking->booking_id
        );

        $this->mock
            ->shouldReceive('checkAccessToBookingByBookingId')
            ->once()
            ->with($this->booking->booking_id)
            ->andReturn(true);

        $expected = $this->mock->checkAccessToBookingByBookingId($this->booking->booking_id);
        $this->assertTrue($expected);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'booking_id' => '645c1d525d49ff37e78653e2'
        ]);
        $this->assertModelExists($this->booking);
    }

    public function test_can_access_booking_by_member_id(): void
    {
        $actual = app(BookingDetailsAccessService::class)->checkAccessToBookingByMemberId(
            $this->booking->member_id
        );

        $this->mock
            ->shouldReceive('checkAccessToBookingByMemberId')
            ->once()
            ->with($this->booking->member_id)
            ->andReturn(true);

        $expected = $this->mock->checkAccessToBookingByMemberId($this->booking->member_id);
        $this->assertTrue($expected);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'booking_id' => '645c1d525d49ff37e78653e2',
            'member_id' => 1
        ]);
        $this->assertModelExists($this->booking);
    }

    public function test_can_access_booking_by_venue_id_booking_id()
    {
        $actual = app(BookingDetailsAccessService::class)->checkAccessToBookingByVenueIdBookingId(
            $this->booking->venue_id,
            $this->booking->booking_id
        );

        $this->mock
            ->shouldReceive('checkAccessToBookingByVenueIdBookingId')
            ->once()
            ->with( $this->booking->venue_id, $this->booking->booking_id)
            ->andReturn(true);

        $expected = $this->mock->checkAccessToBookingByVenueIdBookingId($this->booking->venue_id, $this->booking->booking_id);
        $this->assertTrue($expected);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'booking_id' => '645c1d525d49ff37e78653e2',
            'venue_id' => 30
        ]);
        $this->assertModelExists($this->booking);

    }

    public function test_can_access_booking_by_member_id_booking_id()
    {
        $actual = app(BookingDetailsAccessService::class)->checkAccessToBookingByMemberIdBookingId(
            $this->booking->booking_id,
            $this->booking->member_id,
        );

        $this->mock
            ->shouldReceive('checkAccessToBookingByMemberIdBookingId')
            ->once()
            ->with($this->booking->booking_id, $this->booking->member_id)
            ->andReturn(true);

        $expected = $this->mock->checkAccessToBookingByMemberIdBookingId($this->booking->booking_id, $this->booking->member_id);
        $this->assertTrue($expected);
        $this->assertEquals($expected, $actual);
        $this->assertDatabaseHas('booking_details', [
            'booking_id' => '645c1d525d49ff37e78653e2',
            'venue_id' => 30
        ]);

        $this->assertModelExists($this->booking);

    }
}
