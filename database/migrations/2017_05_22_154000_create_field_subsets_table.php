<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldSubsetsTable extends Migration
{
    public function up()
    {
        Schema::create('maki_field_subsets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('section_id');
            $table->string('type');

            $table->foreign('section_id')
                ->references('id')
                ->on('maki_sections')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('maki_field_subsets');
    }
}
