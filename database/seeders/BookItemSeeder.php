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
            ['uid' => '31321eqw','status_id'=>1,'book_id' => 1, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'ewqwq3232','status_id'=>1,'book_id' => 2, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'eqweqw','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => '233232','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'ewqeq','status_id'=>1,'book_id' => 3, 'for_sale'=>true, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => '32121','status_id'=>1,'book_id' => 3, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'eqweqw32','status_id'=>1,'book_id' => 1, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
            ['uid' => 'eqeqw3243','status_id'=>1,'book_id' => 3, 'for_sale'=>false, 'condition_id'=>1,'created_at' => Carbon::now()->toDateTimeString(),'updated_at' => Carbon::now()->toDateTimeString()],
        ]);
    }
}
