<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineHistoryModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_history_model', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('title');
            $table->integer('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('amount');
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
        Schema::dropIfExists('timeline_history_model');
    }
}
