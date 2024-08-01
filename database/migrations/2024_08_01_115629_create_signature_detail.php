<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signature_detail', function (Blueprint $table) {
            $table->id();
            $table->string('signature_code');
            $table->string('detail_signaturecode');
            $table->integer('user_id');
            $table->integer('signature_type');
            $table->integer('step');
            $table->integer('page_number');
            $table->integer('x');
            $table->integer('y');
            $table->integer('status');
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
        Schema::dropIfExists('signature_detail');
    }
}
