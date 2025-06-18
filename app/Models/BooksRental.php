<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BooksRental extends Model
{
    protected $table = 'books_rental';

    protected $fillable = [
        'book_id',
        'user_id',
        'rental_status',
        'expected_return_date',
        'returned_date',
    ];

    protected function casts()
    {
        return [
            'expected_return_date' => 'immutable_datetime',
            'returned_date' => 'immutable_datetime',
        ];
    }

    public function books(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'book_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
