<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewStockFG extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW stock_child1_vd AS
            SELECT
                *, sum(current_value) AS sum
            FROM
                datas
            WHERE
                `group` = '5'
            AND tag_name <> child1
            GROUP BY
                child1,
                tanggal,
                produk_id "
        );
        DB::statement("CREATE VIEW stock_free_vd AS
            SELECT
                *, sum(current_value) AS sum
            FROM
                datas
            WHERE
                `group` = '5'
            AND child1 = 'Free Stock'
            AND tag_name <> child1
            GROUP BY
                child1,
                child2,
                tanggal,
                produk_id "
        );
        DB::statement("CREATE VIEW rts_vd AS
            SELECT
                *, sum(current_value) AS sum
            FROM
                datas
            WHERE
                `group` = '5'
            AND child1 = 'Cargo'
            AND child2 = 'RTS'
            GROUP BY
                tanggal,
                produk_id "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW IF EXISTS stock_child1_vd' );
        DB::statement( 'DROP VIEW IF EXISTS stock_free_vd' );
        DB::statement( 'DROP VIEW IF EXISTS rts_vd' );
    }
}
