<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CategoryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['category_name'] = 'Config';
    }


    public function Index(Request $request){
        if($request->ajax()){
            $categories = DB::table('category_info')->select('id','name','code','num_books');
            return DataTables::of($categories)
                ->addColumn('actions', function ($row){
                    $canDelete = DB::table('book_categories')->where('category_id','=',$row->id)->count() > 0;
                    if($canDelete){
                        return "<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1' onclick='EditCategory(event)'
                                href='#' data-id='$row->id' data-name='$row->name' data-code='$row->code'>
                                <i class='fa fa-edit' data-id='$row->id' data-name='$row->name' data-code='$row->code'></i>
                             </a>";
                    }
                    return "<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1' onclick='EditCategory(event)'
                                href='#' data-id='$row->id' data-name='$row->name' data-code='$row->code'>
                                <i class='fa fa-edit' data-id='$row->id' data-name='$row->name' data-code='$row->code'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold'
                                    data-id='$row->id' data-name='$row->name' href='#' onclick='RemoveCategory(event)'>
                                    <i class='fa fa-trash' data-id='$row->id' data-name='$row->name'></i>
                              </a>";

                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('category.index')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
           'name' => 'required',
           'code' => 'required'
        ]);

        $result = DB::table('categories')->insert($data);
        if($result){
            return response(['message' => 'category Saved'],201);
        }
        return response(['message' => 'something went wrong'],401);

    }

    public function destroy(Request $request){
        $data = $request->validate([
            'category_id' => 'required'
        ]);
        //TODO: Check to see if there are books with this category
        // if so return error and tell user that these can no be deleted
        $result = DB::table('categories')->where('id','=',$data['category_id'])->delete();
        return response(['message' => 'Category Deleted'],201);
    }

    public function update(Request $request){
        $data = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'code' => 'required'
        ]);
        $result = Category::where('id',$data['category_id'])->update(['name'=>$data['name'],'code'=>$data['code']]);

        if($result){
            return response(['message' => 'category Saved'],201);
        }
        return response(['message' => 'something went wrong'],401);
    }

    public function getCategories(Request $request){
        $term = $request['term'];
        $bookId = $request['bookId'] ?? null;
        $page = $request['page'];
        $count = 10;
        $offset = ($page - 1) * $count;

        if(isset($bookId)){
            $items = DB::table('book_category_info')
                        ->where('book_id','=',$bookId)
                        ->select(DB::raw("category_id as 'id'"), DB::raw("category as 'text'"));
            $totalItems = $items->count();
            if(isset($page)){
                $items->offset($offset)->take($count);
            }
            return response([
                'results' => $items->get(),
                'total_items' => $totalItems
            ]);
        }
        $items = DB::table('categories')
            ->select('id', DB::raw("name as 'text'"));
        $totalItems = $items->count();
        if(isset($page)){
            $items->offset($offset)->take($count);
            }
        return response([
            'results' => $items->get(),
            'total_items' => $totalItems
        ]);
    }
}
