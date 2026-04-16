<?php

namespace App\Models;

use Database\Factories\FilmFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'release_year', 'synopsis'])]
class Film extends Model
{
    /** @use HasFactory<FilmFactory> */
    use HasFactory;

    /**
     * Get the locations for the film.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'release_year' => 'integer',
        ];
    }
}
