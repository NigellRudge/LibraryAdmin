<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relation_types')
            ->insert([
                ['name' =>'Brother','code'=>"BRO"],
                ['name' =>'Sister','code'=>"SIS"],
                ['name' =>'Mother','code'=>"MOM"],
                ['name' =>'Father','code'=>"DAD"],
                ['name' =>'Grand Father','code'=>"GDAD"],
                ['name' =>'Grand Mother','code'=>"GMON"],
                ['name' => 'Son', 'code' => 'Son'],
                ['name' => 'Daughter', 'code' => 'Dau'],
                ['name' => 'Guardian', 'code' => 'GUARD'],
                ['name' => 'Spouse', 'code' => 'SPOUSE'],
            ]);
    }
}
