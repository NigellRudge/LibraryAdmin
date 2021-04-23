<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];
    use HasFactory;
}
