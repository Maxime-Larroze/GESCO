<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->text('societe_name');
            $table->text('siret');
            $table->text('ape');
            $table->text('taux_accompte');
            $table->text('mention_a');
            $table->text('mention_b');
            $table->text('domiciliation');
            $table->text('rib');
            $table->text('iban');
            $table->text('bic');
            $table->text('adresse');
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
        Schema::dropIfExists('parametres');
    }
}
