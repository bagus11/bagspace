<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanOnTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_sub_detail', function (Blueprint $table) {
            $table->float('plan')->after('amount')->default(0);
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
            $table->dropColumn('plan');
            //
        });
    }
}
