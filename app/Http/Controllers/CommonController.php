<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class CommonController extends Controller
{



    protected $data = array();
    public function __construct()
    {
        $this->data['genders'] = DB::table('genders')->select('id','name')->get();
        $this->data['category_name'] = '';
    }

    protected function getItemStatusColumn($status, $value){
        switch ($status){
            case 1:
                return "<span class='bg-success text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 2:
                return "<span class='bg-secondary text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 3:
                return "<span class='bg-info text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 4:
                return "<span class='bg-success text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 5:
                return "<span class='bg-warning text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 6:
                return "<span class='bg-success text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 7:
                return "<span class='bg-success text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            case 8:
                return "<span class='bg-warning text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
            default:
                return "<span class='bg-info text-light' style='font-size: 0.8rem;padding:1px 5px  1px 5px;border-radius: 8px;font-weight: 600'>$value</span>";
                break;
        }
    }
}
