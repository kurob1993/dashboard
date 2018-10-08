<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_groups', function (Blueprint $table) {
            $table->integer('node_group')->primary();
            $table->string('group', 25);
            $table->string('icon', 30);
        });
        Schema::table('sys_menus', function($table) {
            $table->foreign('node_group')
                  ->references('node_group')
                  ->on('sys_groups')
                  ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus');
        Schema::dropIfExists('sys_groups');
    }
}
