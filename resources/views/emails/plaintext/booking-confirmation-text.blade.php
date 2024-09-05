BOOKING CONFIRMED
-------------------------
@if(!empty($bookingData['event']))
 
I'M WATCHING
 
{{ $bookingData['event']['name'] }}
 
-------------------------
@endif
 
BOOKING DETAILS

Venue:        {{ $bookingData['venue']['name'] }}
Date:         {{ $bookingData['bookingDate'] }}
Time:         {{ $bookingData['bookingTime'] }}
No. Guests:   {{ $bookingData['guestCount']}}
 
-------------------------
 
OTHER INFORMATION
 
Name:         {{ $bookingData['bookingName'] }}
Code:         {{ $bookingData['bookingId'] }}
 
@if(!empty($bookingData['specialRequests']))
Special Req:  {{ $bookingData['specialRequests'] }}
 
@endif
@if(!empty($bookingData['fixtureBookingDiff']))
Your booking is {{ $bookingData['fixtureBookingDiff'] }} the event starts
@endif
