<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->foreignId('condition_id')->constrained('condition');
            $table->foreignId('status_id')->constrained('status');
            $table->foreignId('book_id')->constrained('books');
            $table->boolean('for_sale')->default(false);
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
        Schema::dropIfExists('book_item');
    }
}
