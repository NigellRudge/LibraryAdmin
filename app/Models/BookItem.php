<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($copy_id)
 */
class BookItem extends Model
{
    protected $table = 'book_items';
    protected $guarded = [];
    use HasFactory;
}
