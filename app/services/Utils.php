<?php


namespace App\services;


use Illuminate\Support\Carbon;

class Utils
{
    public static function getStatusCode($id){

    }

    public static function toJSDate($value){
        if($value == null){
            return null;
        }
        $temp = Carbon::parse($value);
        $m = $temp->month< 10 ? "0$temp->month": $temp->month;
        $d = $temp->day< 10 ? "0$temp->day": $temp->day;
        return "$m/$d/$temp->year";
    }

    public static function fromJSDate($value){
        return Carbon::parse($value )->toDateString();
    }
}
