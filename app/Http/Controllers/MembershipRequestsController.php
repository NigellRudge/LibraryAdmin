<?php

namespace App\Http\Controllers;

use App\services\MemberService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MembershipRequestsController extends CommonController
{
    /**
     * @var MemberService
     */
    private $service;

    public function __construct(MemberService $service       )
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if($request->ajax()){

        }
        $this->data['statuses'] = DB::table('status')->whereIn('id',[4,5])->select('id','name')->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function terminateMembership(Request $request){

    }

    public function approveRequest(Request $request){

    }

    public function rejectRequest(Request $request){

    }
}
