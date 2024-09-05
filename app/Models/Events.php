<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    public function scopeGetFixtureById(Builder $query, int $fixtureId): Builder
    {
        return $query->where([
            'id' => $fixtureId,
        ]);
    }
}
