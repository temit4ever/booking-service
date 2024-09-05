<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Fanzo\ServiceCommon\Http\Requests\BaseRequest;

class BookingAvailabilityRequest extends BaseRequest
{
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'venueId'   => ['required', 'integer'],
            'partySize' => ['required', 'integer'],
            'date'      => ['required', 'string'],
        ];
    }
}
