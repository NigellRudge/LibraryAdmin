<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('status')->cascadeOnDelete();
            $table->text('description')->nullable()->default(null);
            $table->date('invoice_date');
            $table->decimal('total_amount',12,2);
            $table->decimal('open_amount',12,2);
            $table->boolean('paid')->nullable()->default(null);
            $table->date('paid_date')->nullable()->default(null);
            $table->integer('payment_term')->default(30);
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
        Schema::dropIfExists('invoices');
    }
}
