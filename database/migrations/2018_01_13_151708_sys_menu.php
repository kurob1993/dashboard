<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus', function (Blueprint $table) {
            $table->integer('node_group');
            $table->integer('node_menu');
            $table->string('menu', 25);
            $table->string('link');
            $table->string('level', 11);
            $table->char('status',1);

            $table->foreign('node_group')
                  ->references('node_group')
                  ->on('sys_groups')
                  ->onUpdate('cascade') 
                  ->onDelete('cascade');

            $table->primary(['node_group', 'node_menu']);
            
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
    }
}
