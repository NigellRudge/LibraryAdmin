<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class PricingController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index (Request $request )
    {
        if($request->ajax()){

        }
        return view('pricing.index')->with('data',$this->data);
    }
}
