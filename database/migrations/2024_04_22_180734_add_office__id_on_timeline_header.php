<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfficeIdOnTimelineHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_header', function (Blueprint $table) {
            $table->integer('office_id')->after('user_id');
            $table->integer('status')->after('user_id');
            $table->integer('team_id')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timeline_header', function (Blueprint $table) {
            $table->dropColumn('office_id');
            $table->dropColumn('status');
            $table->dropColumn('team_id');
        });
    }
}
