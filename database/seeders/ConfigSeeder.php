<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
           ['name' => 'Available','code'=>'A'],
           ['name' => 'Out on Loan','code'=>'L'],
           ['name' => 'Pending','code'=>'PEN'],
           ['name' => 'Approved','code'=>'APRVD'],
           ['name' => 'Rejected','code'=>'RJTD'],
           ['name' => 'Paid','code'=>'PAID'],
           ['name' => 'Active','code'=>'ACT'],
           ['name' => 'In-Active','code'=>'IACT'],
           ['name' => 'Partially paid','code'=>'PPD'],
           ['name' => 'Open','code'=>'OPN'],
        ]);
        DB::table('loan_status')->insert([
           ['name' => 'Available'],
           ['name' => 'On Loan'],
           ['name' => 'Overdue'],
           ['name' => 'Returned'],
        ]);
        DB::table('condition')->insert([
            ['name' => 'New','code'=>'N'],
            ['name' => 'Good condition','code'=>'GC'],
            ['name' => 'Damaged','code'=>'D'],
        ]);

        DB::table('membership_types')->insert([
            ['name' => 'single package', 'max_sub_members'=> 0, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name' => 'family package', 'max_sub_members'=> 4, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()]
        ]);
        DB::table('pricing_types')->insert([
            [ 'name' =>'One-time'],
            [ 'name' =>'Monthly'],
        ]);

        DB::table('pricing')->insert([
            [ 'name' =>'single pricing', 'membership_type_id'=>1,'amount'=>150,'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString(), 'pricing_type_id' =>1],
            [ 'name' =>'family pricing', 'membership_type_id'=>2,'amount'=>350,'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString(), 'pricing_type_id' =>1]
        ]);

        DB::table('actions')->insert([
            [ 'name' =>'Approve'],
            [ 'name' =>'Reject'],
        ]);


        DB::table('invoice_types')->insert([
            [ 'name' =>'Membership Fee'],
            [ 'name' =>'Late fee'],
            [ 'name' =>'Damage fee'],
        ]);

        DB::table('languages')->insert([
            [ 'name' =>'English','code'=>'en', 'icon_name' =>'en-flag.gif'],
            [ 'name' =>'Nederlands','code'=>'nl', 'icon_name' =>'ned-flag.gif']
        ]);
    }
}
