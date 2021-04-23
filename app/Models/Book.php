<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static findOrFail($book_id)
 * @method static find($book_id)
 */
class Book extends Model
{
    protected $table = 'books';
    protected $guarded = [];
    use HasFactory;
}
