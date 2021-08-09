<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',35);
            $table->string('last_name',35);
            $table->date('birth_date');
            $table->string('address',35);
            $table->string('email',40);
            $table->string('phone_number',40);
            $table->foreignId('gender_id')->constrained('genders');
            $table->unsignedBigInteger('main_member_id')->nullable()->default(null);
            $table->boolean('is_candidate_member')->default(true);
            $table->foreignId('status_id')->default(3)->constrained('status');
            $table->string('picture',70);
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
        Schema::dropIfExists('members');
    }
}
