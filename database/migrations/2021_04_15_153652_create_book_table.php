<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',80);
            $table->foreignId('author_id')->constrained('author');
            $table->date('publication_date');
            $table->string('isbn',30);
            $table->integer('num_pages');
            $table->text('short_description');
            $table->decimal('sales_price',2);
            $table->decimal('purchase_price',2);
            $table->boolean('age_restricted')->default(false);
            $table->string('cover',80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book');
    }
}
