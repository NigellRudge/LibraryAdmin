<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($request_id)
 */
class MembershipRequest extends Model
{
    protected $table = 'membership_requests';
    protected $guarded = [];
    protected $casts = [
        'request_date' => DateCast::class,
    ];
    use HasFactory;
}
