<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServicesMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_maintenances', function (Blueprint $table) {
            $table->increments('sma_id');
            $table->integer('tse_id')->nullable();
            $table->timestamps();
            $table->string('sma_des', 255)->nullable();
            $table->string('use_nic', 50);
            $table->boolean('sma_act')->default(true);
            $table->integer('acc_id');

            //fk
            $table->foreign('tse_id')->references('tse_id')->on('types_services')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('services_maintenances');
    }
}
