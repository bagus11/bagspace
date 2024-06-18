<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_sub_detail_log', function (Blueprint $table) {
            $table->id();
            $table->string('subdetail_code');
            $table->string('name');
            $table->longText('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('amount');
            $table->integer('pic');
            $table->integer('user_id');
            $table->longText('remark');

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
        Schema::dropIfExists('timeline_sub_detail_log');
    }
}
