<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
        'is_published',
        'book_id',
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
