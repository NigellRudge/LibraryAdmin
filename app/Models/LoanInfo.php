<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($loanId)
 */
class LoanInfo extends Model
{
    protected $table = 'loan_info';
    protected $casts = [
        'loan_date' => DateCast::class,
    ];
    use HasFactory;
}
