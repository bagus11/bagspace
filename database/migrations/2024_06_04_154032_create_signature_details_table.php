<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureDetailsTable extends Migration
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
            $table->unsignedInteger('signature_id');
            $table->string('detail_signature_code')->comment('001/Type/Month/Year(dua angka belakang)');
            $table->string('user_id');
            $table->integer('step');
            $table->integer('status');
            $table->longText('attachment');
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
