<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW datas_vd AS
            SELECT
                tanggal,
                produk_id,
                `group`,
                tag_name,
                sum(current_value) as sum
            FROM
                datas
            GROUP BY
                `group`,produk_id,tanggal"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW IF EXISTS datas_vd' );
    }
}
