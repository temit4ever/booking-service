<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Http\Resources\BookingDetailsResource;
use App\Services\Constant;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Fanzo\ServiceCommon\Microservice\EventMicroservice;
use Fanzo\ServiceCommon\Microservice\VenueMicroservice;

class BookingActionHelper
{
    /**
     */
    public static function getSpecialRequestString(?string $fixtureName, ?string $bookingSpecialRequest): string
    {
        $stringConcat = '';
        if (!empty($bookingSpecialRequest)) {
            $stringConcat .= $bookingSpecialRequest . PHP_EOL;
        }

        if (!empty($fixtureName)) {
            $stringConcat .= $fixtureName . PHP_EOL;
        }

        $stringConcat = $stringConcat . Constant::FANZO_BOOKING_TEXT;
        $textArray = array_unique(explode(PHP_EOL, $stringConcat));
        return implode(PHP_EOL, $textArray);
    }

    /**
     * @return mixed[]
     * @throws \Fanzo\ServiceCommon\Microservice\Exceptions\MicroserviceException
     */
    public static function formatDataForEmail(
        int $internalId,
        BookingDetailsResource $bookingDetails
    ): array {

        $venue = (new VenueMicroservice((string) $bookingDetails['venue_id']))
            ->setFailNicely(true)->getResponseAsArray()['result'] ?? [];
        $event = [];
        if (!empty($bookingDetails['fixture_id'])) {
            $event = (new EventMicroservice((string) $bookingDetails['fixture_id']))
                ->setFailNicely(true)->getResponseAsArray()['result'] ?? [];
        }
        $bookDateTime = !empty($bookingDetails['book_date_time'])
            ? CarbonImmutable::parse($bookingDetails['book_date_time'], 'UTC')
            : null;
        $now = CarbonImmutable::now('UTC');
        $bookingId = !empty($bookingDetails['booking_id']) ? $bookingDetails['booking_id'] : null;
        $bookingName = ($bookingDetails['firstname'] ?? '') . ' ' . ($bookingDetails['lastname'] ?? '');

        return [
            'venue'              => $venue,
            'event'              => $event,
            'bookingId'          => $bookingId,
            'bookingName'        => $bookingName,
            'specialRequests'    => !empty($bookingDetails['special_requests'])
                ? $bookingDetails['special_requests'] : null,
            'guestCount'         => !empty($bookingDetails['number_of_guest'])
                ? $bookingDetails['number_of_guest'] : null,
            'bookingDate'        => !empty($bookDateTime) ? self::formatBookingDate($bookDateTime, $now) : null,
            'bookingTime'        => !empty($bookDateTime) ? self::formatBookingTime($bookDateTime, $now) : null,
            'fixtureBookingDiff' => !empty($event) ?
                self::getBookingAndFixtureTimeDifference(
                    CarbonImmutable::parse($bookingDetails['book_date_time'], 'UTC'),
                    Carbon::parse($event['startTimeUtc'], 'UTC')
                ) : null,
            'amendLink'          => (!empty($bookingId) && !empty($internalId)) ? self::generateEmailLink(
                $internalId,
                $bookingId,
                Constant::LINK_TYPE_AMEND
            ) : null,
            'cancelLink'         => (!empty($bookingId) && !empty($internalId)) ? self::generateEmailLink(
                $internalId,
                $bookingId,
                Constant::LINK_TYPE_CANCEL
            ) : null,
        ];
    }

    /**
     */
    public static function formatBookingDate(CarbonImmutable $bookDateTime, CarbonImmutable $now): string
    {
        return match (true) {
            $bookDateTime->between($now, $now->endOfDay()) => Constant::TODAY_TEXT,
            $bookDateTime->between($now, $now->addDay()->endOfDay()) => Constant::TOMORROW_TEXT,
            default => $bookDateTime->format('d/m/Y'),
        };
    }

    /**
     */
    public static function formatBookingTime(CarbonImmutable $bookDateTime, CarbonImmutable $now): string
    {
        return $bookDateTime->format("H:i");
    }

    /**
     */
    public static function generateEmailLink(int $internalId, string $bookingId, string $linkType): string
    {
        return config('app.booking_url') . $linkType . '/' . $internalId . '/' . $bookingId;
    }

    /**
     */
    public static function getBookingAndFixtureTimeDifference(CarbonImmutable $bookDateTime, Carbon $startTimeUtc): string
    {
        return $bookDateTime->diffForHumans($startTimeUtc);
    }
}
