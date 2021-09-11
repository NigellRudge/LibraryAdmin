<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipRequestsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PricingController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');


Route::group(['middleware' =>['customAuth', 'lang']],function(){
    Route::post('/changeLang', [AuthController::class,'changeLanguage'])->name('change_language');
    Route::group(['prefix'=>'/books','as' => 'books.'],function(){
        Route::group(['prefix' => '/copy','as' => 'copies.'],function(){
            Route::get('/getLoanList',[BookController::class, 'getBookCopyLoansList'])->name('getLoanList');
            Route::get('/{bookCopyId}',[BookController::class, 'showCopy'])->name('show');
            Route::post('/getById',[BookController::class,'getBookCopyById'])->name('getById');
            Route::post('/list',[BookController::class,'getBookItemList'])->name('list');
            Route::patch('/',[BookController::class,'updateCopy'])->name('update');
            Route::post('/',[BookController::class,'storeCopy'])->name('store');
            Route::delete('/',[BookController::class,'destroyCopy'])->name('destroy');
            Route::get('/',[BookController::class,'bookCopies'])->name('index');
        });
        Route::post('/getById',[BookController::class,'getBookById'])->name('getById');
        Route::post('/list',[BookController::class,'getBookList'])->name('list');
        Route::get('/create',[BookController::class,'create'])->name('create');
        Route::get('/getBookCategories',[BookController::class,'getBookCategories'])->name('getBookCategories');
        Route::get('/edit/{book}',[BookController::class,'edit'])->name('edit');
        Route::get('/{book}',[BookController::class,'show'])->name('show');
        Route::post('/{book}',[BookController::class,'update'])->name('update');
        Route::post('/',[BookController::class,'store'])->name('store');
        Route::delete('/',[BookController::class,'destroy'])->name('destroy');
        Route::get('/',[BookController::class,'index'])->name('index');
    });

    Route::group(['prefix' => 'authors','as' =>'authors.'],function(){
        Route::post('/list',[AuthorController::class,'getAuthors'])->name('list');
        Route::post('/',[AuthorController::class,'store'])->name('store');
        Route::delete('/',[AuthorController::class,'destroy'])->name('destroy');
        Route::patch('/',[AuthorController::class,'update'])->name('update');
        Route::get('/',[AuthorController::class,'index'])->name('index');
    });
    Route::group(['prefix' => 'categories','as' =>'category.'],function(){
        Route::post('/list',[CategoryController::class,'getCategories'])->name('list');
        Route::post('/',[CategoryController::class,'store'])->name('store');
        Route::patch('/',[CategoryController::class,'update'])->name('update');
        Route::delete('/',[CategoryController::class,'destroy'])->name('delete');
        Route::get('/',[CategoryController::class,'index'])->name('index');
    });
    Route::group(['prefix' => 'members','as' =>'members.'],function(){
        Route::post('/getById',[MemberController::class,'getById'])->name('getById');
        Route::post('/list',[MemberController::class,'getMembersList'])->name('list');
        Route::post('/',[MemberController::class,'store'])->name('store');
        Route::delete('/',[MemberController::class,'destroy'])->name('destroy');
        Route::get('/terminate/{member}',[MemberController::class,'terminateMembership'])->name('confirmTermination');
        Route::get('/{member}/loans',[MemberController::class, 'getMemberLoans'])->name('getMemberLoans');
        Route::get('/{member}/invoices',[MemberController::class, 'getMemberInvoices'])->name('getMemberInvoices');
        Route::patch('/{member}',[MemberController::class,'update'])->name('update');
        Route::get('/{member}/edit',[MemberController::class,'edit'])->name('edit');
        Route::get('/{member}',[MemberController::class,'show'])->name('show');
        Route::get('/',[MemberController::class,'index'])->name('index');
    });
    Route::group(['prefix' => 'requests','as' =>'requests.'],function(){
        Route::post('/getById',[MembershipRequestsController::class, 'getRequestById'])->name('getById');
        Route::post('/process',[MembershipRequestsController::class,'processRequest'])->name('process');
        Route::post('/',[MembershipRequestsController::class,'store'])->name('store');
        Route::patch('/',[MembershipRequestsController::class,'update'])->name('update');
        Route::delete('/',[MembershipRequestsController::class,'destroy'])->name('destroy');
        Route::get('/',[MembershipRequestsController::class,'index'])->name('index');
    });

Route::group(['prefix' => 'loans','as' =>'loans.'],function(){
    Route::post('/getById',[LoanController::class, 'getById'])->name('getById');
    Route::post('/resolve',[LoanController::class,'resolveLoan'])->name('resolve');
    Route::post('/',[LoanController::class,'store'])->name('store');
    Route::patch('/',[LoanController::class,'update'])->name('update');
    Route::delete('/',[LoanController::class,'destroy'])->name('destroy');
    Route::get('/',[LoanController::class,'index'])->name('index');
});

Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function(){
    Route::post('/getById',[InvoiceController::class,'getById'])->name('getById');
    Route::post('/list',[InvoiceController::class,'invoiceList'])->name('list');
    Route::post('/',[InvoiceController::class,'store'])->name('store');
    Route::patch('/',[InvoiceController::class,'update'])->name('update');
    Route::delete('/',[InvoiceController::class,'delete'])->name('delete');
    Route::get('/',[InvoiceController::class,'index'])->name('index');
});

    Route::group(['prefix' => 'payments', 'as' => 'payments.'], function(){
        Route::post('/getById',[PaymentController::class,'getById'])->name('getById');
        Route::post('/list',[PaymentController::class,'paymentList'])->name('list');
        Route::post('/',[PaymentController::class,'store'])->name('store');
        Route::patch('/',[PaymentController::class,'update'])->name('update');
        Route::delete('/',[PaymentController::class,'delete'])->name('delete');
        Route::get('/',[PaymentController::class,'index'])->name('index');
    });

    Route::group(['prefix'=>'pricing','as'=>'pricing.'],function (){
       Route::post('/',[PricingController::class,'store'])->name('store');
       Route::patch('/',[PricingController::class,'update'])->name('update');
       Route::delete('/',[PricingController::class,'destroy'])->name('destroy');
        Route::post('/list',[PricingController::class,'pricingList'])->name('list');
       Route::get('/',[PricingController::class,'index'])->name('index');
    });

Route::get('/',[DashboardController::class,'index'])->name('dashboard');
});



