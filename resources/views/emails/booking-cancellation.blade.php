<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <style>
            @font-face {
                font-family: "PPFormulaCondensed";
                font-weight: 700;
                src: url('{{ asset('fonts/PPFormulaCondensed-Bold.woff') }}') format('woff');
            }
            @font-face {
                font-family: "Chakra Petch";
                src: url({{ asset('fonts/ChakraPetch-Bold.woff') }}) format('woff');
                font-weight: 700;
            }
            @font-face {
                font-family: "Chakra Petch";
                src: url('{{ asset('fonts/ChakraPetch-SemiBold.woff') }}') format('woff');
                font-weight: 600;
            }
            @font-face {
                font-family: "Chakra Petch";
                src: url('{{ asset('fonts/ChakraPetch-Medium.woff') }}') format('woff');
                font-weight: 500;
            }
            @font-face {
                font-family: "Chakra Petch";
                src: url('{{ asset('fonts/ChakraPetch-Regular.woff') }}') format('woff');
                font-weight: 400;
            }
        </style>
    </head>
    <body>
        <div>
            <div style="display: block;margin: auto;width: 100%;max-width: 426px;padding: 40px 32px 32px 32px;border-radius: 16px;border: 1px solid #EFEEEE;background: #FFF;">
                <h1 style="text-align: center;font-family: 'PPFormulaCondensed', Tahoma, Arial, sans-serif;font-size: 34px;font-style: normal;font-weight: 700;text-transform: uppercase;margin: 0;">BOOKING CANCELLED</h1>
                <div style="display: block;">
                    @if(!empty($bookingData['event']))
                        <!-- FIXTURE DETAILS -->
                        @if(!empty($bookingData['event']['teams'][0]['id']) || !empty($bookingData['event']['teams'][1]['id']))
                            <x-fixture-component.team-fixture-cancel :teams="$bookingData['event']['teams']"></x-fixture-component.team-fixture-cancel>
                        @else
                            <x-fixture-component.single-fixture-cancel :competition-logo="$bookingData['event']['competition']['competitionLogo']" :fixture-name="$bookingData['event']['name']"></x-fixture-component.single-fixture-cancel>
                        @endif
                    @endif
                    <div style="margin-top: 20px;">
                        <div style="display: block;padding: 5px 0;">
                            <div style="display: inline-block;margin-right: 8px;width: 24px;height: 24px;">
                                <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/pin-icon.png" style="width: auto;height: 24px;">
                            </div>
                            <p style="display: inline-block;position: relative; top: -5px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['venue']['name'] }}
                            </p>
                        </div>
                        <div style="display: block;padding: 5px 0;">
                            <div style="display: inline-block;margin-right: 8px;width: 24px;height: 24px;">
                                <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/calendar-icon.png" style="width: auto;height: 24px;">
                            </div>
                            <p style="display: inline-block;position: relative; top: -5px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['bookingDate'] }}
                            </p>
                        </div>
                        <div style="display: block;padding: 5px 0;">
                            <div style="display: inline-block;margin-right: 8px;width: 24px;height: 24px;">
                                <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/clock-icon.png" style="width: auto;height: 24px;">
                            </div>
                            <p style="display: inline-block;position: relative; top: -5px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['bookingTime'] }}
                            </p>
                        </div>
                        <div style="display: block;padding: 5px 0;">
                            <div style="display: inline-block;margin-right: 8px;width: 24px;height: 24px;">
                                <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/user-icon.png" style="width: auto;height: 24px;">
                            </div>
                            <p style="display: inline-block;position: relative; top: -5px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['guestCount'] }}
                            </p>
                        </div>
                    </div>
                    <!-- OTHER DETAILS -->
                    <div style="margin: 15px 0;">
                        <div style="margin-bottom: 10px;">
                            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 600;margin: 0;padding-bottom: 10px;">
                                Name
                            </p>
                            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['bookingName'] }}
                            </p>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 600;margin: 0;padding-bottom: 10px;">
                                Confirmation code
                            </p>
                            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                                {{ $bookingData['bookingId'] }}
                            </p>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #EFEEEE;padding: 20px 0 0;width: 100%;">
                        <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                            If you have any questions about your cancelled booking, please contact
                            {{ $bookingData['venue']['name'] }} on
                            <a href="tel:{{ $bookingData['venue']['phone'] }}" style="color: #000000;">
                                {{ $bookingData['venue']['phone'] }}
                            </a>
                        </p>
                        <a href="{{ $bookingData['venue']['matchpintUrl'] }}">
                            <button style="background-color: #FED900;border: none;border-radius: 16px;padding: 20px;width: 100%;margin-top: 32px;">
                                <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">Make a new booking</p>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
