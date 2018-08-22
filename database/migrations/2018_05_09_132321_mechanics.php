<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mechanics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanics', function (Blueprint $table) {
            $table->string('mec_dni', 15)->primary();
            $table->string('mec_nam', 130)->nullable();
            $table->string('mec_lna', 130)->nullable();
            $table->string('mec_pho', 50)->nullable();
            $table->string('mec_mai', 130)->nullable();
            $table->timestamps();
            $table->string('use_nic', 50)->unsigned()->index();
            $table->boolean('mec_act')->default(true);
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
        Schema::dropIfExists('mechanics');
    }
}
