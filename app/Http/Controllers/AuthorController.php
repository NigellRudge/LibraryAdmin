<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\services\AuthorService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AuthorController extends CommonController
{
    private $authorService;
    public function __construct(AuthorService $service)
    {
        parent::__construct();
        $this->authorService = $service;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->authorService->getAuthors($request->all()))
                ->addColumn('actions', function ($row){
                    $canDelete = DB::table('books')->where('author_id','=',$row->id)->count() > 0;
                    if($canDelete){
                        return " <div class='d-flex flex-row justify-content-end'>"
                                ."<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
                                    <i class='fa fa-eye'></i>
                                </a>"
                                ."<a class='btn-success btn btn-sm rounded text-white text-sm  font-weight-bold mr-1' href='#' onclick='EditAuthor(event)'
                                       data-id='$row->id' data-name='$row->name' data-gender='$row->gender_id'>
                                    <i class='fa fa-edit' data-id='$row->id' data-name='$row->name' data-gender='$row->gender_id'></i>
                                 </a>"
                             ."</div>";
                    }
                    return "<div class='d-flex flex-row justify-content-end'>"
                            ."<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='#'>
                                <i class='fa fa-eye'></i>
                            </a>"
                            ."<a class='btn-success btn btn-sm rounded text-white text-sm  font-weight-bold mr-1 ' href='#' onclick='EditAuthor(event)'
                                  data-id='$row->id' data-name='$row->name' data-gender='$row->gender_id'>
                                    <i class='fa fa-edit' data-id='$row->id' data-name='$row->name' data-gender='$row->gender_id'></i>
                                 </a>"
                            ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' href='#' onclick='DeleteAuthor(event)'
                                   data-name='$row->name' data-id='$row->id' data-gender='$row->gender_id'>
                                    <i class='fa fa-trash' data-id='$row->id' data-name='$row->name' data-gender='$row->gender_id'></i>
                                 </a>"
                        ."</div>";

                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $this->data['genders'] = DB::table('genders')->select('id','name')->get();
        return view('authors.index')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
            'gender' => 'required',
            'name' => 'required'
        ]);

        $result = DB::table('authors')->insert([
            'gender_id' => $data['gender'],
            'name' => $data['name'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if($result){
            return response(['message' => 'Author Stored'],201);
        }
        return response(['message' => 'Something went wrong'],401);
    }

    public function update(Request $request){
        $data = $request->validate([
            'author_id' => 'required',
            'name' => 'required',
            'gender' => 'required'
        ]);
        $result = Author::where('id','=',$data['author_id'])->update(['name' =>$data['name'],'gender_id'=>$data['gender']]);
        if($result){
            return response(['message' => 'Author updated'],201);
        }
        return response(['message' => 'something went wrong'],401);
    }

    public function destroy(Request $request){
        $data = $request->validate([
            'author_id' => 'required'
        ]);

        $result = DB::table('authors')->where('id','=',$data['author_id'])->delete();
        if($result){
            return response(['message' => 'Author removed'],201);
        }
        return response(['message' => 'Something went wrong'],401);

    }

    public function getAuthors(Request $request){
        $term = $request['term'];
        $page = $request['page'];
        $authorId = $request['authorId'] ?? null;
        $take = 10;
        $offSet = ($page - 1) * $take;

        if(isset($authorId)){
            $author = DB::table('author_books')
                ->where('id','=',$authorId)
                ->select('id', DB::raw("author as 'text'"))->get();
            return response()->json([
                'results' => $author,
                'total_item' =>1
            ]);
        }

        $results = DB::table('authors')->where('name','like',"%$term%")->select('id',DB::raw('name as text'));
        $count = $results->count();
        if(isset($page)){
            $results = $results->offset($offSet)->take($take);
        }
        return response()->json([
            'results' => $results->get(),
            'total_item' =>$count
        ]);
    }
}
