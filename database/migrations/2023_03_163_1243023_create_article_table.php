<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('libelle');
            $table->integer('qte');
            $table->string('pmp');
            $table->bigInteger('famillearticle_id')->unsigned();
            $table->foreign('famillearticle_id')->references('id')->on('famillearticles')->onDelete('cascade');
            $table->bigInteger('emplacement_id')->unsigned();
            $table->foreign('emplacement_id')->references('id')->on('emplacements')->onDelete('cascade');
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
        Schema::dropIfExists('articles');
    }
};
