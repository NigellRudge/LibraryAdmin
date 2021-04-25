<?php


namespace App\services;



use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemberService
{

    /**
     * @var InvoiceService
     */
    private $service;

    public function __construct(InvoiceService $service)
    {

        $this->service = $service;
    }

    public function getMembers(array $filterOptions){
        $members = DB::table('member_info')->select('*');
        if(isset($filterOptions['gender']) && $filterOptions['gender'] != 0){
            $members = $members->where('gender_id','=',$filterOptions['gender']);
        }
        return $members;
    }

    public function storeMember(array $data, Request $request = null){
        $member = Member::create($data);
        if ($request->hasFile('cover')){
            $file_name = $member->first_name . '-' .$member->last_name . Carbon::now()->toDateString() . '.' . $request->file('cover')->getClientOriginalExtension();
            $destination = 'public/uploads/members/';
            if($member->picture != null){
                Storage::delete($destination .$member->picture);
            }
            $request->file('cover')->storeAs($destination,$file_name);
            //dd($request->file('image'));
            $member->picture = $file_name;
            $member->save();
        }
        return $member;
    }

    public function updateMember(array $data,$memberId){

    }

    public function deleteMember($memberId){
        //TODO: remove member loans
        //TODO: remove Member late payments
         $member = Member::findOrFail($memberId);
        // finally remove member record
        if(isset($member->picture)){
            $destination = 'public/uploads/members/';
            Storage::delete($destination .$member->picture);
        }
        return $member->delete();
    }

    public function addSubMember(array $data, $memberId){

    }

    public function removeSubMember(array $data, $memberId){

    }

    public function getSubMembers($memberId = null){

    }

    public function getMembershipRequests(array $data, Request $request = null){

    }

    public function storeMembershipRequest(array $data, Request $request){

    }

    public function updateMembershipRequest(array $data, Request $request){

    }


    public function terminateMemberShip($memberId, $date = null, array $data = null){

    }

    public function startMembership($memberId,$date = null, array $data = null){

    }
}
