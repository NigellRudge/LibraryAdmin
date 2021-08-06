<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static findOrFail($loan_id)
 */
class Loan extends Model
{
    protected $table = 'loans';
    protected $guarded = [];
    use HasFactory;
}
