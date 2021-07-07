<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('price');
            $table->string('title');
            $table->string('comment')->nullable();
            $table->uuid('organisation_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('organisation_id')->references('id')->on('organisations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributions');
    }
}
