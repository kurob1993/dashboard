<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('produks', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('produk', 20);
            $table->string('ket');
        });
        DB::statement("ALTER TABLE produks MODIFY id INT NOT NULL AUTO_INCREMENT");

        Schema::create('rkaps', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('produk_id');
            $table->char('bulan');
            $table->char('tahun');
            $table->string('target', 50);
            $table->primary(['id','produk_id']);
            $table->foreign('produk_id')
                  ->references('id')
                  ->on('produks')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::create('datas', function (Blueprint $table) {
            $table->integer('produk_id');
            $table->date('tanggal');
            $table->integer('group');
            $table->string('tag_name');
            $table->string('child1')->nullable();
            $table->string('child2')->nullable();
            $table->integer('current_value')->default(0);
            $table->integer('average_value')->default(0);
            $table->integer('akumulasi')->default(0);
            $table->primary(['produk_id', 'tanggal','group','child1','child2']);

            $table->foreign('produk_id')
                  ->references('id')
                  ->on('produks')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE rkaps MODIFY id INT NOT NULL AUTO_INCREMENT");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datas');
        Schema::dropIfExists('rkaps');
        Schema::dropIfExists('produks');
    }
}
