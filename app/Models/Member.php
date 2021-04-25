<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static findOrFail($memberId)
 */
class Member extends Model
{
    protected $table = 'members';
    protected $guarded = [];
    protected $casts = [
        'birth_date' => DateCast::class,
    ];
    use HasFactory;
}
