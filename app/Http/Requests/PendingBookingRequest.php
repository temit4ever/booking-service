<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\BookingPlatform;
use Fanzo\ServiceCommon\Http\Requests\BaseRequest;

class PendingBookingRequest extends BaseRequest
{
    /**
     */
    protected function prepareForValidation(): void
    {
        // Since, route parameter is not part of request, this approach was taken to validate route parameters.
        $this->merge([
            'venueId' => $this->route('venueId'),
        ]);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'venueId'   => ['required', 'string'],
            'partySize' => ['required', 'integer'],
            'date'      => ['required', 'string'],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function newRequest(?int $venueId, int $partySize, string $date): array
    {
        $bookingPlatform = new BookingPlatform();
        $venueExternalId = $bookingPlatform->getVenuePlatformExternalId($venueId);
        return [
            'venueId'   => $venueExternalId,
            'partySize' => $partySize,
            'date'      => $date,
        ];
    }
}
