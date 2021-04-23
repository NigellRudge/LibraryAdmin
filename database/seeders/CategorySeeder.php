<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name'=>'Science-fiction','code'=>'SCFI','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name'=>'Science','code'=>'SCI','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name'=>'Religious','code'=>'REL','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name'=>'Horror','code'=>'Hor','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name'=>'Drama','code'=>'DRA','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name'=>'Kids','code'=>'KDS','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
        ]);
    }
}
