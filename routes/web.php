<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

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



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::group(['middleware' =>'auth'],function(){
    Route::get('/', function () {
        return view('layout.admin');
    });
    Route::group(['prefix'=>'/books','as' => 'books.'],function(){
        Route::group(['prefix' => '/copy','as' => 'copies.'],function(){
            Route::post('/getById',[BookController::class,'getBookCopyById'])->name('getById');
            Route::patch('/',[BookController::class,'updateCopy'])->name('update');
            Route::post('/',[BookController::class,'storeCopy'])->name('store');
            Route::delete('/',[BookController::class,'destroyCopy'])->name('destroy');
            Route::get('/',[BookController::class,'bookCopies'])->name('index');
        });
        Route::post('/getById',[BookController::class,'getBookById'])->name('getById');
        Route::post('/list',[BookController::class,'getBookList'])->name('list');
        Route::get('/{book}',[BookController::class,'show'])->name('show');
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
        Route::post('/list',[MemberController::class,'getMembersList'])->name('list');
        Route::post('/',[MemberController::class,'store'])->name('store');
        Route::patch('/',[MemberController::class,'update'])->name('update');
        Route::delete('/',[MemberController::class,'destroy'])->name('destroy');
        Route::get('/',[MemberController::class,'index'])->name('index');
    });

});



