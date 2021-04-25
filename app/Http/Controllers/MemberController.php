<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\services\MemberService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberController extends CommonController
{
    private $memberService;
    public function __construct(MemberService $service)
    {
        parent::__construct();
        $this->memberService = $service;
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
                    $showUrl = '';
//                    $canDelete = DB::table('book_items')->where('book_id','=',$row->id)->count() > 0;
//                    if($canDelete){
//                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'
//                                    data-id='$row->id'>
//                                <i class='fa fa-eye' data-id='$row->id'></i>
//                            </a>"
//                            ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' onclick='EditBook(event)' data-id='$row->id'>
//                                <i class='fa fa-edit' data-id='$row->id'></i>
//                             </a>";
//                    }
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'>
                                <i class='fa fa-eye'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id'   onclick='EditMember(event)'>
                                <i class='fa fa-edit ' data-id='$row->id' data-name='$row->name'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteMember(event)' data-name='$row->name' data-id='$row->id'>
                                <i class='fa fa-trash' data-id='$row->id'  data-name='$row->name' ></i>
                             </a>";

                })
                ->rawColumns(['actions'])
                ->make(true);
        }
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

    public function update(Request $request){

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

    public function show(Member $member){

    }

    public function edit(Member $member){

    }

    public function getMembersList(Request $request){

    }
}
