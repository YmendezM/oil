<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fleets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->increments('fle_id');
            $table->string('fle_nam', 250)->nullable();
            $table->string('fle_des', 1000)->nullable();
            $table->timestamps();
            $table->string('use_nic', 50)->unsigned()->index();
            $table->boolean('fle_act')->default(true);
            $table->integer('acc_id')->unsigned()->index();

            //fk
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
        Schema::dropIfExists('fleets');
    }
}
