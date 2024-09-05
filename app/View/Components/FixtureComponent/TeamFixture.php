<?php

declare(strict_types=1);

namespace App\View\Components\FixtureComponent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeamFixture extends Component
{
    /**
     * @param mixed[] $teams
     */
    public function __construct(
        public array $teams
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fixture-component.team-fixture');
    }
}
