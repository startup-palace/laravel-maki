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
            $table->uuid('menu_id');
            $table->uuid('parent_id')->nullable();
            $table->uuid('link_id')->nullable();

            $table->foreign('menu_id')
                ->references('id')
                ->on('maki_menus')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('link_id')
                ->references('id')
                ->on('maki_links')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        Schema::table('maki_menu_items', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('maki_menu_items')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table('maki_menu_items', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::drop('maki_menu_items');
    }
}
