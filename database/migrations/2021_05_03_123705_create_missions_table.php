<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('reference');
            $table->uuid('organisation_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('comment')->nullable();
            $table->integer('deposit');
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('deposed_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('missions');
    }
}
