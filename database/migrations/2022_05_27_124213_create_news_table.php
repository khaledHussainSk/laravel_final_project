<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('NewsDate');
            $table->string('Image',500)->nullable();
            $table->string('Description');
            $table->integer('Category');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
