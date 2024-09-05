<?php

declare(strict_types=1);

namespace App\Services;

class Constant
{
    public const OK = 200;
    public const CREATED = 201;
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const REQUEST_FAILED = 402;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const INTERNAL_SERVER_ERROR = 500;

    public const FANZO_BOOKING_TEXT = 'This booking was made through FANZO';
    public const FANZO_HOLDING_TIME = 420;

    public const MOZREST_PLATFORM_ID = 5;

    public const DEFAULT_COUNTRY_ALIAS = 'GB';
    public const DEFAULT_LOCALE = 'en';

    public const LINK_TYPE_AMEND = 'amend';
    public const LINK_TYPE_CANCEL = 'cancel';
    public const TODAY_TEXT = 'Today';
    public const TOMORROW_TEXT = 'Tomorrow';

    public const CONFIRMATION_EMAIL_SUBJECT = 'Booking Confirmed';
    public const AMENDMENT_EMAIL_SUBJECT = 'Booking Amended';
    public const CANCELLATION_EMAIL_SUBJECT = 'Booking Cancelled';
}
