<?php


namespace App\services;


use App\Models\Book;
use App\Models\BookItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Integer;

class BookService
{

    public function getBooks(array $filterOptions = null){
        $books = DB::table('book_info')->select('id','title','author','isbn','cover','num_copies', 'num_pages');
        return $books->get();
    }

    public function storeBook(array $data, Request $request){
        $data['publication_date'] = Carbon::parse($data['publication_date'])->toDateTimeString();
        $categories = $data['categories'];
        unset($data['categories']);
        $book = Book::create($data);
        foreach ($categories as $category){
            //dd($category);
            DB::table('book_categories')->insert(['book_id' => $book->id, 'category_id' => $category ]);
        }
        if ($request->hasFile('cover')){
            $file_name = $book->title . Carbon::now()->toDateString() . '.' . $request->file('cover')->getClientOriginalExtension();
            $destination = 'public/uploads/covers';
            if($book->cover != null){
                Storage::delete($destination .$book->cover);
            }
            $request->file('cover')->storeAs($destination,$file_name);
            //dd($request->file('image'));
            $book->cover = $file_name;
            $book->save();
        }
        return $book;
    }

    public function deleteBook(array $data){
        $book = Book::find($data['book_id']);
        DB::table('book_categories')->where('book_id','=',$book->id)->delete();
        if(isset($book->cover)){
            $destination = 'public/uploads/covers/';
            Storage::delete($destination .$book->cover);
        }
        return $book->delete();
    }

    public function updateBook($bookId,array $data){

    }

    public function getBookCopies(array $filterOptions){
        $items = DB::table('book_item_info')->select('*');
        if(isset($filterOptions['condition']) && $filterOptions['condition'] != 0){
            $items->where('condition_id','=',$filterOptions['condition']);
        }
        if(isset($filterOptions['status']) && $filterOptions['status'] != 0){
            $items->where('status_id','=',$filterOptions['status']);
        }
        if(isset($filterOptions['bookId']) && $filterOptions['bookId'] != 0){
            $items->where('book_id','=',$filterOptions['bookId']);
        }
        return $items->get();
    }

    public function storeBookCopy(array $data){
        $result = DB::table('book_items')->insert($data);
        return $result;
    }

    public function deleteBookCopy(array $data){
        $result = DB::table('book_items')->where('id','=',$data['copy_id'])->delete();
        //TODO: implement delete for loans that are already fullfiled
        return $result;
    }

    public function updateBookCopy(array $data,$copyId){
        $bookCopy =  BookItem::findOrFail($copyId);
        $result = $bookCopy->update($data);
        return $result;
    }

    public function getCategories(Integer $bookId = null){
        if(isset($bookId)){
            $categories = DB::table('book_categories')->where('book_id','=',$bookId)->select('id','name')->get();
            return $categories;
        }
        return DB::table('categories')->select('id','name')->get();
    }
}
