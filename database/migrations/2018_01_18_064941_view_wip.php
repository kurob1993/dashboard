<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewWip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW wip_child2_vd AS
            SELECT
                *, sum(current_value) AS sum
            FROM
                datas
            WHERE
                `group` = '6'
            AND tag_name = child1
            GROUP BY
                child1,child2,tanggal,produk_id "
        );
        DB::statement("CREATE VIEW wip_child1_vd AS
            SELECT
                *,
                sum(current_value) as sum
            FROM
                datas
            WHERE
                `group` = '6'
                AND tag_name <> child1
            GROUP BY child1,tanggal,produk_id "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW IF EXISTS wip_child2_vd' );
        DB::statement( 'DROP VIEW IF EXISTS wip_child1_vd' );
    }
}
