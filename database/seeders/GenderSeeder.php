<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            ['name' => 'male', 'code' =>'M','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name' => 'female', 'code' =>'F','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
            ['name' => 'unknown', 'code' =>'U','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()]
        ]);
    }
}
