<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('maki_links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('text')->default('');
            $table->string('title')->default('');
            $table->uuid('object_id')->nullable();
            $table->string('object_type')->nullable();
            $table->string('url')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('maki_links');
    }
}
