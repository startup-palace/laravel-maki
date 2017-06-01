<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageSectionTable extends Migration
{
    public function up()
    {
        Schema::create('maki_page_section', function (Blueprint $table) {
            $table->uuid('page_id');
            $table->uuid('section_id');

            $table->foreign('page_id')
                ->references('id')
                ->on('maki_pages')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('section_id')
                ->references('id')
                ->on('maki_sections')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::drop('maki_page_section');
    }
}
