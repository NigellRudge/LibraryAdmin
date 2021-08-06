<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($copy_id)
 */
class BookItemInfo extends Model
{
    protected $table = 'book_item_info';
    protected $guarded = [];
    use HasFactory;
}
