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
        ]);
        DB::table('condition')->insert([
            ['name' => 'New','code'=>'N','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['name' => 'Good condition','code'=>'GC','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['name' => 'Damaged','code'=>'D','created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
    }
}
