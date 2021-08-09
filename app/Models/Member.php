<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

    public function getPictureAttribute($value){
        if(isset($value)){
            return asset(Storage::url('uploads/members/'. $value));
        }
        return $this['gender_id'] == 1 ? asset('storage/placeholder-male.jpg') : asset('storage/placeholder-female.png');
    }

    public function getPictureName(){
        $urlToStorage = asset(Storage::url('uploads/members/'));
        return str_replace($urlToStorage . '/', '' ,$this->picture);
    }

    public function status(){
        return DB::table('status')->where('id','=',$this->status_id)->first()->name;
    }

    public function name(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function gender(){
        return DB::table('genders')->where('id','=',$this->gender_id)->first()->name;
    }
}
