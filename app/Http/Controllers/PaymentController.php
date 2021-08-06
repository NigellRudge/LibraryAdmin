<?php

namespace App\Http\Controllers;

use App\services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends CommonController
{
    private $invoiceService;
    public function __construct(InvoiceService $service)
    {
        parent::__construct();
        $this->invoiceService = $service;
        $this->data['category_name'] = 'Finance';
        $this->data['controller_name'] = 'Payments';
    }

    public function index(Request $request){
        if($request->ajax()){

        }

        return view('payments.index')->with('data',$this->data);
    }

    public function store(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }

    public function getById(Request $request){

    }

    public function paymentList(Request $request){

    }

}
