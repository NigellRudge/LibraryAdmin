<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    protected $data = array();
    public function __construct()
    {
        $this->data['genders'] = DB::table('genders')->select('id','name')->get();
    }
}
