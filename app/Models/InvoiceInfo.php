<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $invoiceId)
 */
class InvoiceInfo extends Model
{
    protected $table = 'invoice_info';
    protected $casts = [
        'invoice_date' => DateCast::class,
    ];
    use HasFactory;
}
