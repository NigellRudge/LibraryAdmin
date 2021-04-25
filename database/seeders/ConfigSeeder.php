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
           ['name' => 'Available','code'=>'A','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
           ['name' => 'Out on Loan','code'=>'L','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
           ['name' => 'Pending','code'=>'PEN','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
           ['name' => 'Approved','code'=>'APRVD','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
           ['name' => 'Rejected','code'=>'RJTD','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
           ['name' => 'Paid','code'=>'PAID','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
        DB::table('condition')->insert([
            ['name' => 'New','code'=>'N','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['name' => 'Good condition','code'=>'GC','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['name' => 'Damaged','code'=>'D','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
        ]);

        DB::table('membership_types')->insert([
            ['name' => 'single package', 'max_sub_members'=> 0, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name' => 'family package', 'max_sub_members'=> 4, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()]
        ]);

        DB::table('pricing')->insert([
            [ 'name' =>'single pricing', 'membership_type_id'=>1,'amount'=>150,'start_date'=> Carbon::now()->toDateTimeString(), 'end_date'=>null, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            [ 'name' =>'family pricing', 'membership_type_id'=>2,'amount'=>350,'start_date'=> Carbon::now()->toDateTimeString(), 'end_date'=>null, 'created_at'=>Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()]
        ]);
    }
}
