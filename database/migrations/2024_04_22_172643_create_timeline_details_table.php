<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_detail', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->string('detail_code');
            $table->string('name');
            $table->longText('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('is_payment');
            $table->integer('is_taxt');
            $table->integer('is_negotiate');
            $table->integer('is_discount');
            $table->integer('status');
            $table->float('percentage');
            $table->integer('payment_status');
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
        Schema::dropIfExists('timeline_detail');
    }
}
