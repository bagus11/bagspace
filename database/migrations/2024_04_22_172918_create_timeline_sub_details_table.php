<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_sub_detail', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('detail_code');
            $table->string('subdetail_code');
            $table->string('name');
            $table->longText('description');
            $table->integer('pic');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status');
            $table->double('amount');
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
        Schema::dropIfExists('timeline_sub_detail');
    }
}
