<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('catagoryID');
            $table->string('title');
            $table->string('image');
            $table->longText('content');
            $table->integer('hit')->default(0);
            $table->integer('status')->default(0);
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('catagoryID')->references('id')->on('categories');
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
}
