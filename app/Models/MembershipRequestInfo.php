<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MembershipRequestInfo extends Model
{
    protected $table = 'membership_request_info';
    protected $guarded = [];
    protected $casts = [
        'request_date' => DateCast::class,
    ];
    use HasFactory;

    public function getMemberPictureAttribute($value){
        if(isset($value)){
            return asset(Storage::url('uploads/members/'. $value));
        }
        return $this['gender_id'] == 1 ? asset('storage/placeholder-male.jpg') : asset('storage/placeholder-female.png');
    }
}
