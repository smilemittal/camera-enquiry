<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEnquiriesTableAddNewCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->string('enquiry_name', 255)->nullable();
            $table->unsignedBigInteger('system_type_id')->after('quantity');
            $table->unsignedBigInteger(('standard_id'))->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('enquiry_name');
            $table->dropColumn('system_type_id');
            $table->dropColumn(('standard_id'));
        });
    }
}
