<div style="margin: 20px 0 0;">
    <div style="display: block;padding: 10px 0;">
        <p style="font-weight: 500;padding-bottom: 20px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;margin: 0;">
            Name
        </p>
        <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
            {{ $bookingName }}
        </p>
    </div>
    <div style="display: block;padding: 10px 0;">
        <p style="font-weight: 500;padding-bottom: 20px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;margin: 0;">
            Confirmation code
        </p>
        <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
            {{ $bookingId }}
        </p>
    </div>
    <div style="display: block;padding: 10px 0;">
        <p style="font-weight: 500;padding-bottom: 20px;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;margin: 0;">
            Key details
        </p>
        <ul style="margin: 0;">
            @if(!empty($specialRequests))
                <li style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                    {{ $specialRequests }}
                </li>
            @endif
            @if(!empty($fixtureBookingDiff))
                <li style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">
                    Your booking is {{ $fixtureBookingDiff }} the event starts
                </li>
            @endif
        </ul>
    </div>
</div>
