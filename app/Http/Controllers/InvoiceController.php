<?php


namespace App\Http\Controllers;


use App\Models\Invoice;
use App\services\InvoiceService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class InvoiceController extends CommonController
{

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    public function __construct(InvoiceService $service)
    {
        parent::__construct();
        $this->invoiceService = $service;
        $this->data['category_name'] = 'Finance';
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->invoiceService->getInvoices($request->all()))
                ->addColumn('actions', function ($row){
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
                                <i class='fa fa-eye'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' onclick='EditInvoice(event)' data-id='$row->id'>
                                <i class='fa fa-edit ' data-id='$row->id'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteInvoice(event)' data-amount='$row->total_amount' data-id='$row->id' data-member='$row->member'>
                                <i class='fa fa-trash' data-id='$row->id' data-amount='$row->total_amount'  data-member='$row->member'></i>
                             </a>";

                })
                ->addColumn('status_info', function ($row){
                    return $this->getItemStatusColumn($row->status_id,$row->status);
                })
                ->addColumn('total_amount_info', function ($row){
                    $data = number_format($row->total_amount,2);
                    return "<span class='font-weight-bold text-dark'>$</span>$data";
                })
                ->addColumn('open_amount_info', function ($row){
                    $data = number_format($row->open_amount,2);
                    return "<span class='font-weight-bold text-dark'>$</span>$data";
                    //return  ' $' . number_format($row->open_amount,2);
                })
                ->rawColumns(['actions','status_info','open_amount_info','total_amount_info'])
                ->make(true);
        }
        $this->data['types'] = DB::table('invoice_types')->select('id','name')->get();
        $this->data['active_members'] = DB::table('members')->where('status_id',7)->count() > 0;
        $this->data['invoice_status'] = DB::table('status')->whereIn('id',[6,9])->select('id','name')->get();
        return view('fees.index')->with('data', $this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
            'member_id' => 'required|min:1',
            'invoice_date' => 'required|date',
            'invoice_type' => 'required',
            'amount' => 'required|min:0.01'
        ]);
        $data['description'] = isset($request['description']) ? $request['description'] : null;
        $data['invoice_date'] = Carbon::parse($data['invoice_date'])->toDateTimeString();
        $result = $this->invoiceService->addInvoice($data);
        if($result){
            return response()->json(['message' => 'Invoice Added'],200);
        }
        return response()->json(['message' => 'Something went wrong'], 421);

    }
    public function update(Request $request){
        $data = $request->validate([
            'member_id' => 'required',
            'amount' => 'required',
            'invoice_type' => 'required',
            'invoice_date' => 'required'
        ]);
        $invoiceId = $request->validate(['invoice_id' => 'required',])['invoice_id'];
        $result = $this->invoiceService->updateInvoice($invoiceId,$data);
        if($result){
            return response()->json(['message' => 'Invoice updated'],200);
        }
        return response()->json(['message' => 'something went wrong'],500);
    }
    public function delete(Request $request){
        $id = $request->validate([
            'invoice_id' => 'required|min:1'
        ])['invoice_id'];
        $result = $this->invoiceService->deleteInvoice($id);
        if($result){
            return response()->json(['message' => 'Invoice deleted'],200);
        }
        return response()->json(['message' => 'something went wrong'],421);
    }
    public function show(Request $request){

    }

    public function invoiceList(Request $request){
        $page = $request['page'] ?? null;
        $resultCount = 10;
        $memberId = $request['member_id'];
        $offset = ($page-1) * $resultCount;
        $items = DB::table('invoice_info')->whereIn('status_id',[9,10])->select('id',DB::raw("CONCAT(invoice_date, ' $', open_amount) as text"));
        if($page){
            $items = $items->offset($offset)->take($resultCount);
        }
        if(isset($memberId) && $memberId != 0){
            $items = $items->where('member_id','=',$memberId);
        }
        return response()->json([
            'results' => $items->get(),
            'total_items' => $items->count()
        ]);
    }

    public function getById(Request $request){
        $id = $request->validate([
            'invoice_id' => 'required|min:1'
        ])['invoice_id'];
        $invoice = $this->invoiceService->getInvoiceInfo($id);
        return response()->json(['invoice' => $invoice],200);
    }

}
