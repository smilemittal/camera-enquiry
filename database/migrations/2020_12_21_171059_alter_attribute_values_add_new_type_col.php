<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAttributeValuesAddNewTypeCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            
            $table->enum('type',['camera','nvr','recorder','switch']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            
            $table->dropColumn('type');
        });
    }
}
