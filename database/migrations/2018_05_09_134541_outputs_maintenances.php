<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OutputsMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs_maintenances', function (Blueprint $table) {
            $table->increments('oma_id');
            $table->integer('dma_id')->nullable();
            $table->timestamps();
            $table->string('oma_des', 255)->nullable();
            $table->string('use_nic', 50)->nullable();
            $table->boolean('oma_act')->default(true);;
            $table->integer('acc_id');

            //fk
            $table->foreign('dma_id')->references('dma_id')->on('detail_maintenances')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('outputs_maintenances');
    }
}
