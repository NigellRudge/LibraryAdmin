<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use App\services\InvoiceService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;



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

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->invoiceService->getPayments($request->all()))
                ->addColumn('actions', function ($row){
                    $name = "$row->member:$$row->amount ($row->payment_date)";
                    return "<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' onclick='EditPayment(event)' data-id='$row->id'>
                            <i class='fa fa-edit' data-id='$row->id'></i>
                         </a>"
                        ."<a class='btn-danger btn btn-sm rounded text-white  font-weight-bold mr-1 ' onclick='DeletePayment(event)' data-id='$row->id' data-name='$name'>
                            <i class='fa fa-trash' data-id='$row->id' data-name='$name'></i>
                         </a>";

                })
                ->addColumn('amount_info', function($row){
                    return  ' $' . number_format($row->amount,2);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('payments.index')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
            'member_id' => 'required|min:1',
            'invoice_id' => 'required|min:1',
            'payment_date' => 'required|date',
            'amount' => 'required'
        ]);
        $result = $this->invoiceService->makePayment($data);
        if($result){
            return response()->json(['message' => 'Payment saved'],200);
        }
        return response()->json(['message' => 'Something went wrong'],500);
    }

    public function update(Request $request){

    }

    public function delete(Request $request){
        $id = $request->validate([
            'payment_id' => 'required'
        ])['payment_id'];
        $result = $this->invoiceService->deletePayment($id);
        if($result){
            return response()->json(['message' => 'Payment saved'],200);
        }
        return response()->json(['message' => 'Something went wrong'],500);
    }

    public function getById(Request $request){
        $id = $request['payment_id'];
        $payment = PaymentInfo::findOrFail($id);
        return response()->json(['payment'=>$payment],200);
    }

    public function paymentList(Request $request){

    }

}
