<?php


namespace App\services;


use App\Models\Book;
use App\Models\BookItem;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    public function __construct()
    {

    }

    public function getLoans(array $filterOptions){
        $items = DB::table('loan_info')->select('*');
        return $items;
    }

    public function storeLoan(array $data){
        $data['loan_date'] = Carbon::parse($data['loan_date'])->toDateTimeString();
        $data['expected_date'] = Carbon::parse($data['loan_date'])->addWeeks(2)->toDateTimeString();
        $result = DB::transaction(function() use($data){

            DB::table('book_items')->where('id','=',$data['book_item_id'])->update(['status_id'=>2]);

            Loan::create($data);

        });
        return $result;
    }

    public function deleteLoan(array $data){

    }

    public function updateLoan(array $data, $loanId){
        // get old loan
        $oldLoan = Loan::findOrFail($loanId);
        // check to see if book item is different
        if($data['book_item_id'] != $oldLoan->book_item_id){
            $oldBook = BookItem::findOrFail($oldLoan->book_item_id);
            $oldBook->update([
                'status_id' => 1
            ]);
        }
        $book = BookItem::findOrFail($data['book_item_id']);
        $book->update([
            'status_id' => 2
        ]);
        $data['loan_date'] = Carbon::parse($data['loan_date'])->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $oldLoan->update($data);
        return true;
        // update old record
    }

    public function resolveLoan(array $data, $loanId=null){
        // set status loan to resolved and return date
        $loan = Loan::findOrFail($data['loan_id']);
        $loan->update([
           'return_date' => Carbon::parse($data['return_date']),
            'status_id' => 4
        ]);
        /// update book status to available
        $book = BookItem::findOrFail($data['book_item_id']);
        $book->update([
            'status_id' => 1
        ]);
        return true;
        // Check to see if the member needs to pay a fee or not
    }

}
