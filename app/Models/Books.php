<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'title',
        'author',
        'stock'
    ]; 

    public function rentals(){
        return $this->hasOne(Rentals::class, 'book_id');
    }
}
