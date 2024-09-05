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
        <h1 style="text-align: center;font-family: 'PPFormulaCondensed', Tahoma, Arial, sans-serif;font-size: 34px;font-style: normal;font-weight: 700;text-transform: uppercase;margin: 0;">BOOKING AMENDED</h1>
        <div>
            @if(!empty($bookingData['event']))
                <h3 style="color: #000000;font-family: 'Chakra Petch','Trebuchet MS', Verdana, sans-serif;font-size: 16px;font-style: normal;font-weight: 600;margin: 20px 0;">I'm watching</h3>
                <!-- FIXTURE DETAILS -->
                @if(!empty($bookingData['event']['teams'][0]['id']) || !empty($bookingData['event']['teams'][1]['id']))
                    <x-fixture-component.team-fixture :teams="$bookingData['event']['teams']"></x-fixture-component.team-fixture>
                @else
                    <x-fixture-component.single-fixture :competition-logo="$bookingData['event']['competition']['competitionLogo']" :fixture-name="$bookingData['event']['name']"></x-fixture-component.single-fixture>
                @endif
                <!-- AT DIVIDER -->
                <div style="display: block;width: 100%;font-family: 'Chakra Petch','Trebuchet MS', Verdana, sans-serif;font-weight: 400;">
                    <div style="display: inline-block;position: relative; width: 45%; top: -3px;height: 1px;background-color: #EFEEEE;"></div>
                    <p style="display: inline-block;position: relative;width: 7.5%;text-align: center;">at</p>
                    <div style="display: inline-block;position: relative; width: 45%; top: -3px;height: 1px;background-color: #EFEEEE;"></div>
                </div>
            @endif
            <!-- VENUE BOOKING DETAILS -->
            <x-booking-detail-component :venue-name="$bookingData['venue']['name']" :booking-date="$bookingData['bookingDate']" :booking-time="$bookingData['bookingTime']" :guest-count="$bookingData['guestCount']"></x-booking-detail-component>
            <!-- LINKS -->
            <x-links-component :venue-data="$bookingData['venue']" :amend-link="$bookingData['amendLink']" :cancel-link="$bookingData['cancelLink']"></x-links-component>
            <!-- OTHER DETAILS -->
            <x-other-detail-component :booking-name="$bookingData['bookingName']" :booking-id="$bookingData['bookingId']" :special-requests="$bookingData['specialRequests']" :fixture-booking-diff="$bookingData['fixtureBookingDiff']"></x-other-detail-component>
        </div>
    </div>
</div>
</body>
</html>
