<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailExpensesFuels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_expenses_fuels', function (Blueprint $table) {
            $table->increments('dex_id');
            $table->timestamps();
            $table->decimal('dex_qua', 20, 4);
            $table->decimal('dex_amu', 20, 4)->nullable();
            $table->string('dex_hor', 50)->nullable();//horometro
            $table->integer('exp_id')->unsigned()->index();
            $table->string('exp_fac', 50)->unsigned()->index()->nullable();
            $table->integer('tfu_id')->unsigned()->index();
            $table->integer('fue_id')->unsigned()->index();
            $table->integer('tan_id')->unsigned()->index()->nullable();
            $table->boolean('dex_act')->default(true);
            $table->integer('acc_id')->unsigned()->index();

            //fk
            $table->foreign('exp_id')->references('exp_id')->on('expenses_fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('exp_fac')->references('exp_fac')->on('expenses_fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tfu_id')->references('tfu_id')->on('type_fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fue_id')->references('fue_id')->on('fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tan_id')->references('tan_id')->on('tanks')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('detail_expenses_fuels');
    }
}
