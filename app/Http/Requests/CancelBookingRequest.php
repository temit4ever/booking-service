<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\BookingDetails;
use Fanzo\ServiceCommon\Http\Requests\BaseRequest;

class CancelBookingRequest extends BaseRequest
{
    /**
     */
    protected function prepareForValidation(): void
    {
        // Since, route parameter is not part of request, this approach was taken to validate route parameters.
        $this->merge([
            'id'        => $this->route('id'),
            'bookingId' => $this->route('bookingId'),
        ]);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'id'        => ['required', 'integer'],
            'bookingId' => ['required', 'string'],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function newRequest(?BookingDetails $details): array
    {
        return [
            'cancelActor' => $details?->firstname . ' ' . $details?->lastname,
        ];
    }
}
