<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookingDetailComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $venueName,
        public string $bookingDate,
        public string $bookingTime,
        public int $guestCount
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.booking-detail-component');
    }
}
