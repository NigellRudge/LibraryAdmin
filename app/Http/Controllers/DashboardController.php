<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['category_name'] = '';
    }

    public function index(Request $request){
        $this->getData();
        return view('dashboard.index')->with('data',$this->data);
    }

    public function getData(){
        $this->data['total_members'] = DB::table('members')->where('status_id','=',7)->count();
        $this->data['total_books'] = DB::table('books')->count();
        $this->data['open_invoices'] = 14;
        $this->data['pending_requests'] = DB::table('membership_requests')->where('status_id','=',3)->count();
    }
}
