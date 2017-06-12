<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('maki_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description');
            $table->string('type');
        });
    }

    public function down()
    {
        Schema::drop('maki_menus');
    }
}
