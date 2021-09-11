<?php


namespace App\services;



use App\Models\Member;
use App\Models\MembershipRequest;
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
        if(isset($filterOptions['status']) && $filterOptions['status'] != 0){
            $members = $members->where('status_id','=',$filterOptions['status']);
        }
        return $members;
    }

    public function storeMember(array $data, Request $request = null){
        if(isset($data['request_date'])){
            unset($data['request_date']);
        }
        if(isset($data['processed_date'])){
            unset($data['processed_date']);
        }
        if(isset($data['membership_type_id'])){
            unset($data['membership_type_id']);
        }
        $member = Member::create($data);
        if ($request->hasFile('picture')){
            $file_name = $member->first_name . '-' .$member->last_name . Carbon::now()->toDateString() . '.' . $request->file('picture')->getClientOriginalExtension();
            $destination = 'public/uploads/members/';
            if($member->picture != null){
                Storage::delete($destination .$member->picture);
            }
            $request->file('picture')->storeAs($destination,$file_name);
            //dd($request->file('image'));
            $member->picture = $file_name;
            $member->save();
        }
        return $member;
    }

    public function updateMember(array $data,$memberId, Request $request){
//        dd($data);
        if(isset($data['request_date'])){
            unset($data['request_date']);
        }
        if(isset($data['processed_date'])){
            unset($data['processed_date']);
        }
        if(isset($data['membership_type_id'])){
            unset($data['membership_type_id']);
        }
        if(isset($data['request_id'])){
            unset($data['request_id']);
        }
        $member = Member::findOrFail($memberId);
        $member->update($data);
        if ($request->hasFile('picture')){
            $file_name = $member->first_name . '-' .$member->last_name . Carbon::now()->toDateString() . '.' . $request->file('picture')->getClientOriginalExtension();
            $destination = 'public/uploads/members/';
            if($member->picture != null){
                Storage::delete($destination .$member->picture);
            }
            $request->file('picture')->storeAs($destination,$file_name);
            //dd($request->file('image'));
            $member->picture = $file_name;
            $member->save();
        }
        return $member;
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

    public function getMembershipRequests(array $filterOptions = null){
        $items = DB::table('membership_request_info')->select('*');
        if(isset($filterOptions['status']) && $filterOptions['status'] != 0){
            $items = $items->where('status_id','=',$filterOptions['status']);
        }
        if(isset($filterOptions['type']) && $filterOptions['type'] != 0){
            $items = $items->where('membership_type_id','=',$filterOptions['type']);
        }
        //dd($items->get());
        return $items;
    }

    public function storeMembershipRequest(array $data, Request $request){

        // 1 create member
        $member = $this->storeMember($data,$request);
        // 2 create membership request
        return DB::table('membership_requests')->insert([
            'request_date' => Carbon::parse($data['request_date'])->toDateTimeString(),
            'processed_date' => null,
            'member_id' => $member->id,
            'membership_type_id' => $data['membership_type_id'],
            'status_id' => 3,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public function destroyMembershipRequest(array $data){
        $membershipRequest = DB::table('membership_requests')->where('id','=',$data['request_id'])->select('*')->first();
        $member = Member::findOrFail($membershipRequest->member_id);

        $result1= DB::table('membership_requests')->where('id','=',$membershipRequest->id)->delete();
        $result2 = $this->deleteMember($member->id);
        return $result2;
    }



    public function updateMembershipRequest(array $data, Request $request){
        //get membership request
        $memberShipRequest = DB::table('membership_requests')->where('id','=',$data['request_id'])->first();
        return DB::table('membership_requests')->where('id','=',$memberShipRequest->id)->update([
            'request_date' => Carbon::parse($data['request_date'])->toDateTimeString(),
            'processed_date' => null,
            'membership_type_id' => $data['membership_type_id'],
            'status_id' => 3,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }


    public function terminateMemberShip($memberId, $date = null, array $data = null){

    }

    public function startMembership($memberId,$date = null, array $data = null){

    }

    public function processMembership(array $data){
        $result = false;
        $membershipRequest = MembershipRequest::findOrFail($data['request_id']);
        $newMembershipStatusId = $data['result_id'] == 1 ? 4 : 5;
        $newMemberStatusId =$data['result_id'] == 1 ? 7 : 8;
        DB::transaction(function() use($newMembershipStatusId, $newMemberStatusId,$data,$membershipRequest,$result){
            DB::table('membership_requests')->where('id','=',$data['request_id'])->update(['status_id' => $newMembershipStatusId, 'processed_date'=> $data['process_date']]);
            DB::table('members')->where('id','=',$membershipRequest->member_id)->update(['status_id' => $newMemberStatusId]);
            $result = true;
        });
        //TODO: create entree invoice
        return $result;
    }

    public function getMemberLoans($memberId,array $filterOptions = null){
        $loans = DB::table('loan_info')->where('member_id','=',$memberId);
        if(isset($filterOptions['status_id']) && $filterOptions['status_id'] == 0){
            $loans = $loans->where('status_id','=',$filterOptions['status_id']);
        }
        return $loans->get();
    }
}
