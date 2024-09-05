<?php

declare(strict_types=1);

namespace App\View\Components\FixtureComponent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SingleFixture extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $fixtureName,
        public string $competitionLogo
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fixture-component.single-fixture');
    }
}
