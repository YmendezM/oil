<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanks', function (Blueprint $table) {
            $table->increments('tan_id');
            $table->decimal('tan_cap', 20, 4);
            $table->decimal('tan_qua', 20, 4);
            $table->integer('fue_id')->unsigned()->index();
            $table->string('use_nic', 50)->unsigned()->index();
            $table->integer('sts_id')->unsigned()->index();
            $table->string('tan_des', 250)->nullable();
            $table->timestamps();
            $table->boolean('tan_act')->default(true);
            $table->integer('acc_id')->unsigned()->index();

            //fk
            $table->foreign('fue_id')->references('fue_id')->on('fuels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('use_nic')->references('use_nic')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sts_id')->references('sts_id')->on('stations')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('tanks');
    }
}
