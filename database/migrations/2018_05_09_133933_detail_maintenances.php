<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_maintenances', function (Blueprint $table) {
            $table->increments('dma_id');
            $table->integer('mai_id')->nullable();
            $table->timestamps();
            $table->integer('dsm_id')->nullable();
            $table->string('mec_dni', 15)->nullable();
            $table->string('use_nic', 50);
            $table->boolean('dma_act')->default(true);;
            $table->integer('acc_id');

            //fk
            $table->foreign('dma_id')->references('dma_id')->on('detail_maintenances')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dsm_id')->references('dsm_id')->on('detail_services_maintenances')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('mec_dni')->references('mec_dni')->on('mechanics')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('use_nic')->references('use_nic')->on('users')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('detail_maintenances');
    }
}
