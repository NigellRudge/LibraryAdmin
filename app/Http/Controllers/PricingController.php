<?php


namespace App\Http\Controllers;


use App\Providers\PriceService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PricingController extends CommonController
{
     private $service;
    public function __construct(PriceService $pricingService)
    {
        parent::__construct();
        $this->service = $pricingService;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index (Request $request )
    {
        if($request->ajax()){
            return DataTables::of($this->service->getPrices($request->all()))
                ->addColumn('actions', function ($row){
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1'ata-id='$row->id'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'>
                                <i class='fa fa-edit ' data-id='$row->id' data-title='$row->title'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold'data-id='$row->id'>
                                <i class='fa fa-trash' data-id='$row->id'></i>
                             </a>";

                })->addColumn('amount_info', function ($row){
                    $data = number_format($row->amount,2);
                    return "<span class='font-weight-bold text-dark'>$</span>$data";
                })
                ->addColumn('per_day_info', function ($row){
                    $data = number_format($row->amount_per_day,2);
                    return "<span class='font-weight-bold text-dark'>$</span>$data";
                })
                ->rawColumns(['actions','amount_info','per_day_info'])
                ->make(true);
        }
        $this->data['pricing_types'] = DB::table('pricing_types')->select('id','name')->get();
        $this->data['membership_types'] = DB::table('membership_types')->select('id','name')->get();
        return view('pricing.index')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
           'name' => 'required',
           'amount' => 'required',
           'membership_type_id' => 'required',
           'type_id' => 'required'
        ]);
    }

    public function destroy(Request $request){

    }

    public function update(Request $request){

    }

    public function pricingList(Request $request){

    }
}
