<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->enum('type',['camera','nvr']);
            $table->integer('display_order');
            $table->unsignedBigInteger('system_type_id');
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->foreign('system_type_id')->references('id')->on('system_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
