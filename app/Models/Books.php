<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    protected $fillable = [
        'book_name',
        'published_year',
        'availability',
        'author_id',
        'genre_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Authors::class, 'author_id', 'id');
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genres::class, 'genre_id', 'id');
    }
}
