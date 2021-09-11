<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberInfo;
use App\services\InvoiceService;
use App\services\MemberService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MemberController extends CommonController
{
    private $memberService;
    private $invoiceService;
    public function __construct(MemberService $service, InvoiceService $invoiceService)
    {
        parent::__construct();
        $this->memberService = $service;
        $this->invoiceService = $invoiceService;
        $this->data['category_name'] = 'Members';
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->memberService->getMembers($request->all()))
                ->addColumn('actions', function ($row){
                    $showUrl = route('members.show',['member' => $row->id]);
                    $editUrl = route('members.edit',['member' => $row->id]);
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'>
                                <i class='fa fa-eye'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' href='$editUrl'>
                                <i class='fa fa-edit'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteMember(event)' data-name='$row->name' data-id='$row->id'>
                                <i class='fa fa-trash' data-id='$row->id'  data-name='$row->name' ></i>
                             </a>";

                })
                ->addColumn('membership_status',function($row){
                    return $this->getItemStatusColumn($row->status_id,$row->status);
                })
                ->rawColumns(['actions','membership_status'])
                ->make(true);
        }
        $this->data['statuses'] = DB::table('status')->whereIn('id',[3,7,8])->select('id','name')->get();
        return view('members.index')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender_id' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $result = $this->memberService->storeMember($data,$request);
        if($result){
            return response(['message' => 'Member Stored'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    public function update(Request $request, Member $member){
//        dd($request->all());
        $data = $request->validate([
            'gender_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'phone_number' => 'required',
            'address' => 'required',
//            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
//        dd($member->id);
        $result = $this->memberService->updateMember($data,$member->id, $request);
        return redirect(route('members.index'))->with('message', 'member updated');
    }

    public function destroy(Request $request){
        $data = $request->validate([
           'member_id' => 'required'
        ]);
        $result = $this->memberService->deleteMember($data);
        if($result){
            return response(['message' => 'Member Deleted'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    /**
     * @param Request $request
     * @param Member $member
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show(Request $request, Member $member){
        $this->data['member'] = $member;
        $this->data['invoice_types'] = DB::table('invoice_types')->select('id','name')->get();
        return view('members.test')->with('data',$this->data);
    }

    public function edit(Member $member){
        $this->data['member'] = $member;
        $this->data['genders'] = DB::table('genders')->select('*')->get();
        return view('members.edit')->with('data',$this->data);
    }

    public function getMembersList(Request $request){
        $status = $request['status'] ?? null;
        $page = $request['page'] ?? null;
        $resultCount = 10;
        $offset = ($page-1) * $resultCount;

        $items = DB::table('member_info')->select('id',DB::raw('name as text'));
        if($status){
            $items = $items->where('status_id','=',$status);
        }
        if($page){
            $items = $items->offset($offset)->take($resultCount);
        }
        return response()->json([
            'results' => $items->get(),
            'total_items' => $items->count()
        ]);
    }

    public function getMemberLoans(Request $request, Member $member){
        return DataTables::of($this->memberService->getMemberLoans($member->id,null))
            ->addColumn('actions', function ($row){
                return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
                                <i class='fa fa-eye'></i>
                            </a>"
                    ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteLoan(event)'  data-book='$row->book'  data-id='$row->id'>
                                <i class='fa fa-trash' data-id='$row->id'  data-book='$row->book' ></i>
                             </a>";

            })
            ->rawColumns(['actions',''])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param Member $member
     * @return mixed
     * @throws Exception
     */
    public function getMemberInvoices(Request $request, Member $member){
        $data['member_id'] = $member->id;
        return DataTables::of($this->invoiceService->getInvoices($data))
            ->addColumn('actions', function ($row){
                return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
                                <i class='fa fa-eye'></i>
                            </a>"
                    ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditMember(event)'>
                                <i class='fa fa-edit ' data-id='$row->id'></i>
                             </a>"
                    ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteMember(event)'  data-id='$row->id'>
                                <i class='fa fa-trash' data-id='$row->id'></i>
                             </a>";

            })
            ->rawColumns(['actions',''])
            ->make(true);
    }

    public function terminateMembership(Member $member){
        $this->data['member'] = $member;
        return view('members.confirm')->with('data', $this->data);
    }

    public function getById(Request $request){
        $id = $request['memberId'];
        $member = MemberInfo::findOrFail($id);
        return response()->json(['member' =>$member],201);
    }
}
