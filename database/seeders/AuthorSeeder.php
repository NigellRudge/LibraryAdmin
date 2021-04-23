<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
           ['name'=>'Deyon Rudge','gender_id'=>'1','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
           ['name'=>'Eric Rudge','gender_id'=>'1','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
           ['name'=>'Myles Monroe','gender_id'=>'1','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
           ['name'=>'Ruth Kramp','gender_id'=>'2','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
           ['name'=>'Lunette Meye','gender_id'=>'2','created_at' => Carbon::now()->toDateTimeString(), 'updated_at'=> Carbon::now()->toDateTimeString()],
        ]);
    }
}
