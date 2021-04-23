<?php


namespace App\services;


use Illuminate\Support\Facades\DB;

class MemberService
{
    public function getMembers(array $filterOptions){
        $members = DB::table('member_info')->select('*');
        if(isset($filterOptions['gender']) && $filterOptions['gender'] != 0){
            $members = $members->where('gender_id','=',$filterOptions['gender']);
        }
        return $members;
    }

    public function storeMember(array $data){

    }

    public function updateMember(array $datam,$memberId){

    }

    public function deleteMember($memberId){

    }
}
