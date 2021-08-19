<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->string('code',191);
            $table->boolean('rtl')->default(0);
            $table->timestamps();
        });
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('lang',10);
            $table->text('lang_key');
            $table->text('lang_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
        Schema::dropIfExists('languages');
    }
}
