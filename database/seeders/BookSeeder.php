<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
           ['title' => 'Harry Potter and the sorcerers stone','author_id'=> 1,'publication_date'=>Carbon::now()->toDateTimeString(),'isbn'=>'11223-2323-22','num_pages'=>'467','short_description'=>'A young boi discovers that he and his parent have magical powers',
               'sale_price'=>25.50,'purchase_price'=>18.50,'age_restricted'=>false,'cover'=>'No cover','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
            ['title' => 'Harry Potter and the chamber of secrets','author_id'=> 2,'publication_date'=>Carbon::now()->toDateTimeString(),'isbn'=>'11223-23232-44345','num_pages'=>'511','short_description'=>'Harry learns about chamber with a lot of secrets',
               'sale_price'=>24.50,'purchase_price'=>16.50,'age_restricted'=>false,'cover'=>'No cover','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
            ['title' => 'A song of Fire and Ice','author_id'=> 3,'publication_date'=>Carbon::now()->toDateTimeString(),'isbn'=>'445566-2323-22','num_pages'=>'677','short_description'=>'Travel to westeros and meet the families fighting for the iron throne while the dead march',
               'sale_price'=>55.50,'purchase_price'=>45.50,'age_restricted'=>false,'cover'=>'No cover','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
            ['title' => 'A dance of dragons','author_id'=> 4,'publication_date'=>Carbon::now()->toDateTimeString(),'isbn'=>'11223-2323-22','num_pages'=>'467','short_description'=>'A dragon queens, a bastard and the dead',
               'sale_price'=>61.50,'purchase_price'=>54.50,'age_restricted'=>false,'cover'=>'No cover','created_at'=>Carbon::now()->toDateTimeString(),'updated_at'=>Carbon::now()->toDateTimeString()],
        ]);
    }
}
