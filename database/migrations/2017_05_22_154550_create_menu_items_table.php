<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('maki_menu_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('title');
            $table->uuid('link_id')->nullable();

            $table->uuid('parent_id')->nullable();
            $table->string('parent_type')->nullable();

            $table->foreign('link_id')
                ->references('id')
                ->on('maki_links')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::drop('maki_menu_items');
    }
}
