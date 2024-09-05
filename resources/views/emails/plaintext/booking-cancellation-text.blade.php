BOOKING CANCELLED
-------------------------
@if(!empty($bookingData['event']))
 
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
-------------------------
If you have any questions about your cancelled booking, please contact {{ $bookingData['venue']['name'] }} on {{ $bookingData['venue']['phone'] }}
