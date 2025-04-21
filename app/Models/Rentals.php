<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rentals extends Model
{
    use HasFactory;
    protected $table = 'rentals';
    protected $primaryKey = 'rentals_id';

    protected $fillable = [
        'user_id',
        'book_id',
        'nama_penyewa',
        'rental_date',
        'return_date',
        'status'
    ];

    public function books(): BelongsTo {
        return $this->belongsTo(Books::class, 'book_id', 'book_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}
