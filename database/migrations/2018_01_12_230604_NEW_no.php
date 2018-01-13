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
            $table->string('a', 40)->default("10000;");
            $table->string('b', 40)->default("10000;");
            $table->string('c', 40)->default("10000;");
            $table->string('d', 40)->default("10000;");
            $table->string('e', 40)->default("10000;");
            $table->string('f', 40)->default("10000;");
            $table->string('g', 40)->default("10000;");
            $table->string('h', 40)->default("10000;");
            $table->string('i', 40)->default("10000;");
            $table->string('j', 40)->default("10000;");
            $table->string('k', 40)->default("10000;");
            $table->string('l', 40)->default("10000;");
            $table->string('m', 40)->default("10000;");
            $table->string('n', 40)->default("10000;");
            $table->string('o', 40)->default("10000;");
            $table->string('p', 40)->default("10000;");
            $table->string('q', 40)->default("10000;");
            $table->string('r', 40)->default("10000;");
            $table->string('s', 40)->default("10000;");
            $table->string('t', 40)->default("10000;");
            $table->string('u', 40)->default("10000;");
            $table->string('v', 40)->default("10000;");
            $table->string('w', 40)->default("10000;");
            $table->string('x', 40)->default("10000;");
            $table->string('y', 40)->default("10000;");
            $table->string('z', 40)->default("10000;");
            $table->string('$', 40)->default("10000;");
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
