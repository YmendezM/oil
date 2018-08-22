<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SparesDetailMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spares_detail_maintenances', function (Blueprint $table) {
            $table->increments('sdm_id');
            $table->integer('spa_id')->nullable();
            $table->integer('dma_id')->nullable();
            $table->timestamps();
            $table->boolean('dma_act')->default(true);;
            $table->integer('acc_id');

            //fk
            $table->foreign('spa_id')->references('spa_id')->on('spares')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dma_id')->references('dma_id')->on('detail_maintenances')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('spares_detail_maintenances');
    }
}
