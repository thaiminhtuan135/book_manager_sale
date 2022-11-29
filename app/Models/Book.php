<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Book extends Model
{
    use HasFactory ,Sortable;
    protected $table = 'book';
    protected $sortable = [
        'title',
        'author',
        'category',
        'release_date',
        'number_page',
        'image'];
    protected $fillable = [
        'title',
        'author',
        'category',
        'release_date',
        'number_page',
        'image',
    ];
}
