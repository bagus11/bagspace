<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signature_header', function (Blueprint $table) {
            $table->id();
            $table->integer('approval_type');
            $table->string('title');
            $table->longText('description');
            $table->unsignedInteger('user_id');
            $table->string('attachment');
            $table->integer('step_approval');
            $table->integer('status');
            $table->unsignedInteger('step_approval_id');
            $table->string('signature_code')->comment('001/Type/Month/Year(dua angka belakang)');
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
        Schema::dropIfExists('signature_header');
    }
}
