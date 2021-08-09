<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class PaymentInfo extends Model
{
    protected $table = 'payment_info';
    protected $casts = [
        'payment_date' => DateCast::class,
    ];
    use HasFactory;
}
