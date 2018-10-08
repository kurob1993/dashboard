<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Referensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi', function (Blueprint $table) {
            $table->increments('group');
            $table->string('tag_name', 50);
            $table->string('unit', 50);
            $table->string('description', 50);
            $table->string('sap_tag_name', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referensi');
    }
}
