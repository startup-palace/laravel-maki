<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSectionsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maki_sections', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('maki_sections')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maki_sections', function (Blueprint $table) {
            $table->dropForeign('maki_sections_parent_id_foreign');
        });
    }
}
