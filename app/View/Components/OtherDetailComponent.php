<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OtherDetailComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $bookingName,
        public ?string $bookingId,
        public ?string $specialRequests,
        public ?string $fixtureBookingDiff
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.other-detail-component');
    }
}
