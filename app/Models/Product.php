<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'book_id',
        'user_id',
        'amount',
    ];

    public function books()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }

}
