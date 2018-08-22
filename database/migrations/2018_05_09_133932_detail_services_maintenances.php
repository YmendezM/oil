<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailServicesMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_services_maintenances', function (Blueprint $table) {
            $table->increments('dsm_id');
            $table->integer('sma_id')->nullable();
            $table->timestamps();
            $table->string('dsm_des', 255)->nullable();
            $table->string('use_nic', 50);
            $table->boolean('dsm_act')->default(true);;
            $table->integer('acc_id');

            //fk
            $table->foreign('sma_id')->references('sma_id')->on('services_maintenances')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('detail_services_maintenances');
    }
}
