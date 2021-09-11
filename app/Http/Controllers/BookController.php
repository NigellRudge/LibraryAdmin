<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookInfo;
use App\Models\BookItem;
use App\Models\BookItemInfo;
use App\services\BookService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BookController extends CommonController
{
    private $bookService;
    public function __construct(BookService $service)
    {
        parent::__construct();
        $this->bookService = $service;
        $this->data['category_name'] = 'Books';
        $this->data['action_name'] = '';
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if($request->ajax()){
            return DataTables::of($this->bookService->getBooks())
                ->addColumn('actions', function ($row){
                    $showUrl = route('books.show',['book' => $row->id]);
                    $editUrl = route('books.edit',['book' => $row->id]);
                    $canDelete = DB::table('book_items')->where('book_id','=',$row->id)->count() > 0;
                    if($canDelete){
                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'
                                    data-id='$row->id'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>"
                            ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' href='$editUrl' data-id='$row->id'>
                                <i class='fa fa-edit' data-id='$row->id'></i>
                             </a>";
                    }
                    return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' href='$showUrl'>
                                <i class='fa fa-eye'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 '  href='$editUrl'>
                                <i class='fa fa-edit ' data-id='$row->id' data-title='$row->title'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteBook(event)' data-id='$row->id' data-title='$row->title'>
                                <i class='fa fa-trash' data-id='$row->id' data-title='$row->title'></i>
                             </a>";

                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $this->data['categories'] = DB::table('categories')->select('id','name')->get();
        $this->data['action_name'] = 'Index';
        return view('books.index')->with('data',$this->data);
    }

    public function create(Request $request){
        return view('books.create')->with('data',$this->data);
    }

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'sale_price' => 'required',
            'purchase_price' => 'required',
            'publication_date' => 'required',
            'age_restricted' => 'required',
            'num_pages' => 'required',
            'isbn' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'required',
            'categories' => 'required|array'
        ]);
        $result = $this->bookService->storeBook($data,$request);
        if($result){
            return redirect(route('books.index'))->with('message',trans('common.books_save_success_full_label'));
        }
        return redirect(route('books.index'))->with('error',trans('common.general_error_label'));
    }

    public function edit(Book $book){
        //dd($book);
        $this->data['book'] = $book;
        return view('books.edit')->with('data',$this->data);
    }

    public function update(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'sale_price' => 'required',
            'purchase_price' => 'required',
            'publication_date' => 'required',
            'age_restricted' => 'required',
            'num_pages' => 'required',
            'isbn' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'required',
            'categories' => 'required|array'
        ]);
        $result = $this->bookService->updateBook($data,$request);
        if($result){
            return redirect(route('books.index'))->with('message','Books Stored');
        }
        return redirect(route('books.index'))->with('error','Something went wrong');
    }

    public function destroy(Request $request){
        $data = $request->validate([
            'book_id' => 'required'
        ]);

        $result = $this->bookService->deleteBook($data);
        if($result){
            return response(['message' => 'Book deleted'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    public function show(Request $request, BookInfo $book){
        $this->data['book'] = $book;
        $this->data['categories'] = DB::table('book_category_info')->where('book_id',$book->id)->select('category')->get();
        $this->data['conditions'] = DB::table('condition')->whereIn('id',[1,2])->select('id','name')->get();
        //dd($this->data);
        return view('books.show')->with('data',$this->data);
    }

    public function getBookList(Request $request){
        $term = $request['term'];
        $page = $request['page'];
        $take = 10;
        $offSet = ($page - 1) * $take;

        $results = DB::table('books')->where('title','like',"%$term%")->select('id',DB::raw('title as text'));
        $count = $results->count();
        if(isset($page)){
            $results = $results->offset($offSet)->take($take);
        }
        return response()->json([
            'results' => $results->get(),
            'total_item' =>$count
        ]);
    }

    public function getBookById(Request $request){
        $data = $request->validate([
            'book_id' => 'required'
        ]);
        $book = Book::findOrFail($data['book_id']);
        $categories = DB::table('book_categories')->where('book_id','=', $book->id)->select('id')->get();
        return response()->json(['book'=>$book,'categories' => $categories],201);
    }
    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function bookCopies(Request $request){
        if($request->ajax()){
            return DataTables::of($this->bookService->getBookCopies($request->all()))
                ->addColumn('actions', function ($row){
                    $showUrl = route('books.copies.show',['bookCopyId' => $row->id]);
                    $canDelete = $row->status_id == 2;
                    if($canDelete){
                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' onclick='viewDetails(event)'
                                    data-id='$row->id'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>";
                    }
                        return "<a class='btn btn-primary rounded btn-sm text-white font-weight-bold mr-1' onclick='viewDetails(event)' data-id='$row->id'>
                                <i class='fa fa-eye' data-id='$row->id'></i>
                            </a>"
                        ."<a class='btn-success btn btn-sm rounded text-white  font-weight-bold mr-1 ' data-id='$row->id' data-title='$row->title'  onclick='EditBookCopy(event)'>
                                <i class='fa fa-edit ' data-id='$row->id' data-title='$row->title'></i>
                             </a>"
                        ."<a class='btn btn-danger btn-sm rounded text-white font-weight-bold' onclick='DeleteBookCopy(event)' data-title='$row->title' data-id='$row->id' data-uid='$row->uid'>
                                <i class='fa fa-trash' data-id='$row->id' data-uid='$row->uid'  data-title='$row->title' ></i>
                             </a>";

                })
                ->addColumn('book_status',function($row){
                    return $this->getItemStatusColumn($row->status_id,$row->status);
                })
                ->addColumn('condition_info',function($row){
                    return $this->getConditionColumn($row->condition_id,$row->condition);
                })
                ->rawColumns(['actions','book_status','condition_info'])
                ->make(true);
        }
        $this->data['statuses'] = DB::table('status')->whereIn('id',[1,2])->select('id','name')->get();
        $this->data['conditions'] = DB::table('condition')->select('id','name')->get();
        return view('books.copy.index')->with('data',$this->data);
    }

    public function storeCopy(Request $request){
        $data = $request->validate([
            'book_id' => 'required',
            'status_id' => 'required',
            'condition_id' => 'required',
            'uid' => 'required'
        ]);
        $data['status_id'] = intval($data['status_id']);
        $result = $this->bookService->storeBookCopy($data);
        if($result){
            return response(['message' => 'Book Copy Stored'],201);
        }
        return response(['message' => 'Something went wrong' ],401);
    }

    public function showCopy(Request $request, $bookCopyId){
        $book = DB::table('book_item_info')->where('id','=',$bookCopyId)
                    ->select('*')->first();
        $this->data['book_copy'] = $book;

        return view('books.copy.show')->with('data', $this->data);
    }


    public function updateCopy(Request $request){
        $data = $request->validate([
            'book_id' => 'required',
            'status_id' => 'required',
            'condition_id' => 'required',
            'uid' => 'required'
        ]);
        $result = $this->bookService->updateBookCopy($data,$request['copy_id']);
        if($result){
            return response(['message' => trans('common.books_copy_save_success_full_label')],201);
        }
        return response(['message' => trans('common.general_error_label') ],401);
    }

    public function destroyCopy(Request $request){
        $data = $request->validate([
            'copy_id' => 'required'
        ]);
        $result = $this->bookService->deleteBookCopy($data);
        if($result){
            return response(['message' => trans('common.books_copy_deleted_label')],201);
        }
        return response(['message' => trans('common.general_error_label') ],401);
    }

    public function getBookCopyById(Request $request){
        $data = $request->validate([
            'copy_id' => 'required'
        ]);
        $book = BookItemInfo::findOrFail($data['copy_id']);
        return response()->json(['book'=>$book],201);
    }

    public function getBookItemList(Request $request){
        $term = $request['term'];
        $page = $request['page'];
        $status = $request['status'] ?? null;
        $take = 10;
        $offSet = ($page - 1) * $take;

        $results = DB::table('book_item_info')
                        ->where('title','like',"%$term%")
                        ->orWhere('uid','like',"%$term%")
                        ->select('id',DB::raw( "CONCAT('(', uid,')', ' ', title) as text"));
        if ($status){
            $request = $results->where('status_id','=',$status);
        }
        $count = $results->count();
        if(isset($page)){
            $results = $results->offset($offSet)->take($take);
        }
        return response()->json([
            'results' => $results->get(),
            'total_item' =>$count
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getBookCopyLoansList(Request $request){
        $id = $request['copy_id'];
        $loans = DB::table('loan_info')->where('book_item_id','=', $id)
                ->select('id','member','status','loan_date', 'expected_date')->get();
        return DataTables::of($loans)->make(true);
    }

}
