<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maki_field_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('owner_id');
            $table->string('owner_type');
            $table->string('field');
            $table->uuid('object_id')->nullable();
            $table->string('object_type')->nullable();
            $table->text('data')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('maki_field_values');
    }
}
