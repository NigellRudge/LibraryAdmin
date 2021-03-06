<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($invoiceId)
 */
class Invoice extends Model
{
    protected $guarded = [];
    use HasFactory;
}
