<?php

namespace App\Http\Controllers;

use App\Models\MembershipRequest;
use App\Models\MembershipRequestInfo;
use App\services\MemberService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MembershipRequestsController extends CommonController
{
    /**
     * @var MemberService
     */
    private $memberService;

    public function __construct(MemberService $service       )
    {
        parent::__construct();
        $this->memberService = $service;
        $this->data['category_name'] = 'Members';
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of($this->memberService->getMembershipRequests($request->all()))
                ->addColumn('actions', function ($row){
                    switch ($row->status_id){
                        case 4:
                            return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' onclick='openDetails(event)' data-id='$row->id'>
                                        <i class='fa fa-eye'  data-id='$row->id'></i>
                                    </a>";
                            break;
                        case 5:
                            return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' onclick='openDetails(event)' data-id='$row->id'>
                                        <i class='fa fa-eye'  data-id='$row->id'></i>
                                    </a>"
                                    ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold mr-1' onclick='DeleteRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
                                        <i class='fa fa-trash' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
                                     </a>";
                            break;
                        default:
                            return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' onclick='openDetails(event)' data-id='$row->id'>
                                        <i class='fa fa-eye'  data-id='$row->id'></i>
                                    </a>"
                                    ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditRequest(event)'>
                                        <i class='fa fa-edit ' data-id='$row->id' data-member='$row->member'></i>
                                    </a>"
                                    ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold mr-1' onclick='DeleteRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
                                        <i class='fa fa-trash' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
                                     </a>"
                                    ."<a class='btn btn-info btn-sm rounded text-white font-weight-bold' onclick='ProcessRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
                                        <i class='fa fa-check' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
                                    </a>";
                            break;
                    }
//                    if($row->status_id = 3){
//                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
//                                <i class='fa fa-eye'></i>
//                            </a>"
//                            ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditRequest(event)'>
//                                <i class='fa fa-edit ' data-id='$row->id' data-member='$row->member'></i>
//                             </a>"
//                            ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold mr-1' onclick='DeleteRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
//                                <i class='fa fa-trash' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
//                             </a>"
//                            ."<a class='btn btn-info btn-sm rounded text-white font-weight-bold' onclick='ProcessRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
//                                <i class='fa fa-check' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
//                             </a>";
//                    }
//                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'>
//                                <i class='fa fa-eye'></i>
//                            </a>"
//                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditRequest(event)'>
//                                <i class='fa fa-edit ' data-id='$row->id' data-member='$row->member'></i>
//                             </a>"
//                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteRequest(event)' data-member='$row->member' data-id='$row->id' data-date='$row->request_date'>
//                                <i class='fa fa-trash' data-id='$row->id'  data-member='$row->member' data-date='$row->request_date' ></i>
//                             </a>";

                })
                ->addColumn('status_info',function($row){
                    return $this->getItemStatusColumn($row->status_id,$row->status);
                })
                ->rawColumns(['actions','status_info'])
                ->make(true);
       }
        $this->data['statuses'] = DB::table('status')->whereIn('id',[3,4,5])->select('id','name')->get();
        $this->data['membership_types'] = DB::table('membership_types')->select('*')->get();
        $this->data['actions'] = DB::table('actions')->select('*')->get();
        return view('members.requests.index')->with('data',$this->data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'request_date' => 'required|date',
            'membership_type_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender_id' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $result = $this->memberService->storeMembershipRequest($data, $request);
        if($result){
            return response(['message' => 'Request and member Stored'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //s
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'request_id' => 'required',
            'request_date' => 'required|date',
            'membership_type_id' => 'required',
        ]);
        $result = $this->memberService->updateMembershipRequest($data, $request);
        if($result){
            return response(['message' => 'Request and member Stored'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'request_id' => 'required'
        ]);
        $result = $this->memberService->destroyMembershipRequest($data);
        if($result){
            return response(['message' => 'Request and member removed'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    public function terminateMembership(Request $request){

    }

    public function processRequest(Request $request)
    {
        $data = $request->validate([
            'request_id' => 'required',
            'result_id' => 'required',
            'process_date' => 'required|date'
        ]);

        $data['process_date'] = Carbon::parse($data['process_date'])->toDateTimeString();
        $result = $this->memberService->processMembership($data);
        return response(['message' => 'Request and member Stored'], 201);

    }

    public function getRequestById(Request $request){
        $id = $request['requestId'];
        $request = MembershipRequestInfo::where('id','=',$id)->select("*")->first();
        $request->birth_date = Carbon::parse($request->birth_date)->monthName . ' '.  Carbon::parse($request->birth_date)->day   . ' ' . Carbon::parse($request->birth_date)->year;
        return response()->json(['request' => $request],201);
    }
}
