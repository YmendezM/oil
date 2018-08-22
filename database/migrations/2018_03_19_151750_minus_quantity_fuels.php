<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MinusQuantityFuels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec("
        CREATE FUNCTION minus_quantity_fuels() RETURNS trigger
            LANGUAGE plpgsql
            AS $$
        DECLARE BEGIN
	        UPDATE fuels SET fue_qua=fue_qua - NEW.dex_qua
             WHERE fuels.fue_id  = NEW.fue_id;
            RETURN NULL;
        END;
        $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER detail_expense_quantity ON detail_expenses_fuels');
        DB::unprepared('DROP FUNCTION minus_quantity_fuels()');
    }
}
