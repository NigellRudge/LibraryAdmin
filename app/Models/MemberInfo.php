<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class MemberInfo extends Model
{
    protected $table = 'member_info';
    use HasFactory;
}
