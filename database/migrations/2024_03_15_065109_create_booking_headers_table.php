<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_header', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_id');
            $table->string('title');
            $table->longText('description');
            $table->longText('meeting_code');
            $table->integer('location_id');
            $table->integer('type');
            $table->integer('status');
            $table->integer('approval_id');
            $table->date('date_start');
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('booking_header');
    }
}
