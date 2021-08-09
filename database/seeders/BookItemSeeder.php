<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_items')->insert([
            ['uid' => 'HARPTR1','status_id'=>1,'book_id' => 1, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'HARPTR2','status_id'=>1,'book_id' => 2, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'SOIF1','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'SOIF2','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'SOIF4','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'SOIF3','status_id'=>1,'book_id' => 3, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'HARPTR4','status_id'=>1,'book_id' => 1, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'SOIF5','status_id'=>1,'book_id' => 3, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
    }
}
