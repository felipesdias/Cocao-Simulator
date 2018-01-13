<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NEWNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no', function (Blueprint $table) {
            $table->increments('id');
            $table->string('a', 40);
            $table->string('b', 40);
            $table->string('c', 40);
            $table->string('d', 40);
            $table->string('e', 40);
            $table->string('f', 40);
            $table->string('g', 40);
            $table->string('h', 40);
            $table->string('i', 40);
            $table->string('j', 40);
            $table->string('k', 40);
            $table->string('l', 40);
            $table->string('m', 40);
            $table->string('n', 40);
            $table->string('o', 40);
            $table->string('p', 40);
            $table->string('q', 40);
            $table->string('r', 40);
            $table->string('s', 40);
            $table->string('t', 40);
            $table->string('u', 40);
            $table->string('v', 40);
            $table->string('w', 40);
            $table->string('x', 40);
            $table->string('y', 40);
            $table->string('z', 40);
            $table->string('$', 40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('no');
    }
}
