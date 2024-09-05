<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LinksComponent extends Component
{
    /**
     * @param mixed[] $venueData
     */
    public function __construct(
        public array $venueData,
        public string $amendLink,
        public string $cancelLink
    ) {
    }

    /**
     */
    public function render(): View|Closure|string
    {
        return view('components.links-component');
    }
}
