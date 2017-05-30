<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->datetime('published_at')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
        });
    }

    public function down()
    {
        Schema::drop('pages');
    }
}
