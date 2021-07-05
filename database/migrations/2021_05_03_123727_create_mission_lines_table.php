<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_lines', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('mission_id');
            $table->string('title');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('unity');
            $table->timestamps();
            $table->foreign('mission_id')->references('id')->on('missions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_lines');
    }
}
