<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;
use phpDocumentor\Reflection\Types\Integer;

class CommonController extends Controller
{



    protected $data = array();
    public function __construct()
    {
        $this->data['genders'] = DB::table('genders')->select('id','name')->get();
        $this->data['category_name'] = '';

    }

    public function getLang(){
        if(auth()->user()) {
            $this->data['lang_name'] = "Negro";
        }
    }

    protected function getItemStatusColumn($status, $value){
        $spanStyle = "style='font-size: 0.8rem;padding:5px;border-radius: 10px;font-weight: 600'";
        $textColor = "text-white";
        switch ($status){
            case 1:
            case 4:
            case 6:
            case 7:
                $color='bg-success';
                break;
            case 2:
                $color='bg-secondary';
                break;
            case 5:
            case 8:
                $color ='bg-warning';
                break;
            case 10:
                $color='bg-danger';
                break;
            default:
                $color = 'bg-info';
                break;
        }
        return "<span class='$color $textColor' $spanStyle>$value</span>";
    }

    protected function getConditionColumn($status, $value){
        $spanStyle = "style='font-size: 0.8rem;padding:5px;border-radius: 10px;font-weight: 600'";
        $textColor = "text-white";
        switch ($status){
            case 2:
                $color='bg-secondary';
                break;
            case 3:
                $color ='bg-warning';
                break;
            default:
                $color = 'bg-success';
                break;
        }
        return "<span class='$color $textColor' $spanStyle>$value</span>";
    }
}
