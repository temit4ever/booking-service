<div style="width: 100%;">
    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $venueData['name'] }}, {{ $venueData['address1'] }}&destination_place_id={{ $venueData['googlePlaceId'] }}" style="display: block;width: 100%;border-top: 1px solid #EFEEEE;padding: 15px 0;text-decoration: none;">
        <div style="display:inline-block;position: relative;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/direction-icon.png" style="width: auto;height: 24px;">
        </div>
        <div style="display:inline-block;position: relative;top: -3px;">
            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">Get directions</p>
        </div>
        <div style="display:inline-block;position:relative;float: right;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/chevron-icon.png" style="width: auto;height: 24px;">
        </div>
    </a>
    <a href="{{ $amendLink }}" style="display: block;align-items: center;width: 100%;border-top: 1px solid #EFEEEE;padding: 15px 0;text-decoration: none;">
        <div style="display:inline-block;position: relative;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/note-icon.png" style="width: auto;height: 24px;">
        </div>
        <div style="display:inline-block;position: relative;top: -3px;">
            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">Amend booking</p>
        </div>
        <div style="display:inline-block;position:relative;float: right;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/chevron-icon.png" style="width: auto;height: 24px;">
        </div>
    </a>
    <a href="{{ $cancelLink }}" style="display: block;align-items: center;width: 100%;border-top: 1px solid #EFEEEE;padding: 15px 0;text-decoration: none;border-bottom: 1px solid #EFEEEE;">
        <div style="display:inline-block;position: relative;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/cross-icon.png" style="width: auto;height: 24px;">
        </div>
        <div style="display:inline-block;position: relative;top: -3px;">
            <p style="display:inline-block;color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">Cancel booking</p>
        </div>
        <div style="display:inline-block;position:relative;float: right;top: 3px;margin-right: 8px;width: 24px;height: 24px;">
            <img src="https://matchpint-cdn.matchpint.cloud/imagenes/icons/bookings/chevron-icon.png" style="width: auto;height: 24px;">
        </div>
    </a>
</div>
