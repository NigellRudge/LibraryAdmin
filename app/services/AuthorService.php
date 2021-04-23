<?php


namespace App\services;


use Illuminate\Support\Facades\DB;

class AuthorService
{
    public function getAuthors(array $filterOptions = null){
        $authors = DB::table('author_info')->select('id','name','gender','num_books','gender_id');
        return $authors->get();
    }
}
