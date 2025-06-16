<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genres extends Model
{
    protected $fillable = ['name'];

    public function books(): HasMany
    {
        return $this->hasMany(Books::class, 'genre_id', 'id');
    }
}
