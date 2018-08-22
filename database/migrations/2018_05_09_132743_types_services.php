<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TypesServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_services', function (Blueprint $table) {
            $table->increments('tse_id');
            $table->timestamps();
            $table->string('tse_des', 255)->nullable();
            $table->string('use_nic', 50);
            $table->boolean('tse_act')->default(true);
            $table->integer('acc_id');

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
        Schema::dropIfExists('types_services');
    }
}
