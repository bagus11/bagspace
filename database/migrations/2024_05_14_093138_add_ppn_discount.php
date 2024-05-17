<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpnDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_sub_detail', function (Blueprint $table) {
            $table->double('ppn')->after('amount');
            $table->double('discount')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timeline_sub_detail', function (Blueprint $table) {
            $table->dropColumn('ppn');
            $table->dropColumn('discount');
        });
    }
}
