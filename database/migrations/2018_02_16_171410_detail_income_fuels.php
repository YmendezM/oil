<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailIncomeFuels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_income_fuels', function (Blueprint $table) {
            $table->increments('din_id');
            $table->decimal('din_qua', 20, 4);
            $table->decimal('din_amu', 20, 4)->nullable();
            $table->integer('inc_id')->unsigned()->index();
            $table->string('inc_fac', 50)->unsigned()->index()->nullable();
            $table->integer('fue_id')->unsigned()->index();
            $table->integer('tan_id')->unsigned()->index()->nullable();
            //$table->integer('ume_id')->unsigned()->index();
            $table->boolean('din_act')->default(true);
            $table->integer('acc_id')->unsigned()->index();

            //fk
            $table->foreign('inc_id')->references('inc_id')->on('income_fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('inc_fac')->references('inc_fac')->on('income_fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fue_id')->references('fue_id')->on('fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tan_id')->references('tan_id')->on('tanks')->onUpdate('cascade')->onDelete('restrict');
            //$table->foreign('ume_id')->references('ume_id')->on('units_measure')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('acc_id')->references('acc_id')->on('accounts')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_income_fuels');
    }
}
