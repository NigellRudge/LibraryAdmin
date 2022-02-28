<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use App\Models\Loan;
use App\Models\LoanInfo;
use App\services\LoanService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LoanController extends CommonController
{
    /**
     * @var LoanService
     */
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        parent::__construct();
        $this->loanService = $loanService;
        $this->data['category_name'] = 'Loans';
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->loanService->getLoans($request->all()))
                ->addColumn('actions', function ($row){
                    $canEdit = $row->status_id != 4;
                    if($canEdit){
                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' data-id='$row->id'   onclick='loanDetails(event)'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>"
                            ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditLoan(event)'>
                                <i class='fa fa-edit ' data-id='$row->id'></i>
                             </a>"
                            ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold mr-1' onclick='DeleteLoan(event)' data-id='$row->id' data-member='$row->member' data-book='$row->book'>
                                <i class='fa fa-trash' data-id='$row->id' data-member='$row->member' data-book='$row->book'></i>
                             </a>"
                            ."<a class='btn btn-info btn-sm rounded text-white font-weight-bold' onclick='ResolveLoan(event)' data-id='$row->id' data-member='$row->member' data-book='$row->book'>
                                <i class='fa fa-check' data-id='$row->id' data-member='$row->member' data-book='$row->book'></i>
                         </a>";
                    }
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' data-id='$row->id'   onclick='loanDetails(event)'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>"
                            ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold mr-1' onclick='DeleteLoan(event)' data-id='$row->id' data-member='$row->member' data-book='$row->book'>
                                 <i class='fa fa-trash' data-id='$row->id' data-member='$row->member' data-book='$row->book'></i>
                            </a>";

                })
                ->addColumn('membership_status',function($row){
                    switch ($row->status){
                        case 7:
                            return "<span class='bg-success p-1 rounded font-weight-bold text-dark' style='font-size: 0.8rem'>$row->status</span>";
                            break;
                        case 8:
                            return "<span class='bg-warning p-1 rounded font-weight-bold text-dark' style='font-size: 0.8rem'>$row->$row->status</span>";
                            break;
                        default:
                            return "<span class='bg-info p-1 rounded font-weight-bold text-dark' style='font-size: 0.8rem'>$row->status</span>";
                            break;
                    }
                })
                ->rawColumns(['actions','membership_status'])
                ->make(true);
        }
        $this->data['loan_status_types'] = DB::table('loan_status')->whereIn('id',[2,3,4])->select('id', 'name')->get();
        return view('loans.index')->with('data',$this->data);
    }
    public function store(Request $request){
        $data = $request->validate([
           'member_id' => 'required',
           'book_item_id' => 'required',
           'loan_date' => 'required',
        ]);
//        $result = $this->loanService->storeLoan($data);
        $data['status_id'] = 2;
        $data['loan_date'] = Carbon::parse($data['loan_date'])->toDateTimeString();
        $data['expected_date'] = Carbon::parse($data['loan_date'])->addWeeks(2)->toDateTimeString();
        $result = DB::transaction(function() use($data){

            DB::table('book_items')->where('id','=',$data['book_item_id'])->update(['status_id'=>2]);

            Loan::create($data);

        });
            return response(['message' => trans('common.loan_saved_label')],201);
    }

    public function update(Request $request){
        $loanId = $request->validate([
            'loan_id' => 'required'
        ])['loan_id'];
        $data = $request->validate([
            'member_id' => 'required',
            'book_item_id' => 'required',
            'loan_date' => 'required|date'
        ]);
        $result = $this->loanService->updateLoan($data,$loanId);
        return response()->json(['message' => 'Loan Updated'],201);

    }

    public function destroy(Request $request){
        $data = $request->validate([
           'loan_id' => 'required'
        ]);
        $loan = Loan::findOrFail($data['loan_id']);
        $bookItem = BookItem::findOrFail($loan->book_item_id);
        $bookItem->update(['status_id'=>1]);
        $loan->delete();
        return response(['message' => 'Loan removed'],201);
    }

    public function resolveLoan(Request $request){
        $data = $request->validate([
            'loan_id' => 'required',
            'member_id' => 'required',
            'book_item_id' => 'required',
            'return_date' => 'required'
        ]);
        $result = $this->loanService->resolveLoan($data);
        if($result){
            return response()->json(['message'=>'book returned'],201);
        }
        return response()->json(['message'=>'something went wrong'],401);
    }

    public function getById(Request $request){
        $loanId = $request['loanId'];
        $loan = LoanInfo::findOrFail($loanId);
        return response()->json(['loan' =>$loan],201);
    }
}
