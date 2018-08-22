<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Maintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->increments('mai_id');
            $table->timestamps();
            $table->string('use_nic_en', 50)->nullable();
            $table->timestamp('mai_fec_ex', 0)->nullable();
            $table->string('use_nic_ex', 50)->nullable();
            $table->string('veh_pla', 15)->nullable();
            $table->string('mai_des', 1500)->nullable();
            $table->integer('sta_id')->nullable();
            $table->boolean('mai_act')->default(true);;
            $table->integer('acc_id');

            //fk
            $table->foreign('use_nic_en')->references('use_nic')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('use_nic_ex')->references('use_nic')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sta_id')->references('sta_id')->on('status')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('maintenances');
    }
}
