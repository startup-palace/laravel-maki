<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('maki_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->datetime('published_at')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('unique_id')->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::drop('maki_pages');
    }
}
