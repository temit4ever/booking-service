<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Helpers\BookingActionHelper;
use App\Services\Constant;
use Fanzo\ServiceCommon\Http\Requests\BaseRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CreateBookingRequest extends BaseRequest
{
    /**
     */
    protected function prepareForValidation(): void
    {
        // Since, route parameter is not part of request, this approach was taken to validate route parameters.
        $this->merge([
            'bookingId' => $this->route('bookingId'),
        ]);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'bookingId'         => ['required', 'string'],
            'specialRequest'    => ['string', 'nullable'],
            'fixtureId'         => ['nullable', 'integer'],
            'contact.firstname' => ['required', 'string'],
            'contact.lastname'  => ['required', 'string'],
            'contact.email'     => ['required', 'string'],
            'contact.telephone' => ['required', 'integer'],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function newRequest(?string $fixtureName, Collection $request): array
    {
        /**
         * @var \Fanzo\ServiceCommon\Auth\AuthUser $user
         */
        $user = Auth::user();
        $specialRequest = BookingActionHelper::getSpecialRequestString(
            $fixtureName,
            $request['specialRequest'] ?? null
        );

        return [
            "notes"   => $specialRequest,
            "contact" => [
                "firstname" => $request['contact']['firstname'],
                "lastname"  => $request['contact']['lastname'],
                "email"     => $request['contact']['email'],
                "telephone" => $request['contact']['telephone'],
                "locale"    => Constant::DEFAULT_LOCALE,
                "address"   => [
                    "country" => $user->getCountryOfResidenceAlias(),
                ],
            ],
        ];
    }
}
