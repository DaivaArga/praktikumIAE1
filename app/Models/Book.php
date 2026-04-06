<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Book.php
class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'publisher',
        'year',
        'stock',
        'description',
    ];
}
