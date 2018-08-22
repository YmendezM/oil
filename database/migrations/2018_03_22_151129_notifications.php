<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('not_id');
            $table->string('not_des', 15);
            $table->string('veh_pla', 15)->nullable();
            $table->string('dri_dni', 15)->nullable();
            $table->decimal('not_cmi', 20, 4);
            $table->decimal('not_cex', 20, 4);
            $table->timestamps();
            $table->boolean('view')->default(false);
            $table->boolean('not_act')->default(true);
            $table->integer('acc_id')->unsigned()->index();

            //fk
            $table->foreign('veh_pla')->references('veh_pla')->on('vehicles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dri_dni')->references('dri_dni')->on('drivers')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('notifications');
    }
}
