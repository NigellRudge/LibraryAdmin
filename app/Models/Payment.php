<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static findOrFail($paymentId)
 */
class Payment extends Model
{
    protected $table = 'payments';
    protected $guarded = [];
    protected $casts = [
        'payment_date' => DateCast::class,
    ];
    use HasFactory;
}
