<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    use HasFactory;
    protected $fillable = ['name', 'isbn', 'authors', 'country', 'number_of_pages', 'release_date', 'publisher'];

    /* Convert author JSON field to array */
    protected $casts = ['authors' => 'array'];

    /* Only show this fields in all() */
    protected $visible = ['id', 'name', 'isbn', 'authors', 'number_of_pages', 'publisher', 'country', 'release_date'];
}
