<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdetailMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdetail_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('permission_name');
            $table->string('link');
            $table->integer('status');
            $table->integer('id_submenus');
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
        Schema::dropIfExists('subdetail_menus');
    }
}
