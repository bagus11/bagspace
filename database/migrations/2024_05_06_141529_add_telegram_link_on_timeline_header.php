<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelegramLinkOnTimelineHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_header', function (Blueprint $table) {
            $table->string('link')->after('status');
            $table->string('token')->after('status');
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
            $table->dropColumn('link');
            $table->dropColumn('token');
        });
    }
}
