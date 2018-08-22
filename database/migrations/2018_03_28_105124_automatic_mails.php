<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutomaticMails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('automatic_mails', function (Blueprint $table) {
            $table->increments('aem_id');
            $table->string('use_nic', 50);
            $table->string('aem_des', 250)->nullable();
            $table->string('aem_bod', 1000)->nullable();
            $table->string('aem_asu', 250)->nullable();
            $table->string('aem_hou', 250)->nullable();
            $table->string('aem_fre', 250)->nullable();
            $table->string('aem_for', 250)->nullable();
            $table->string('aem_tre', 250)->nullable();
            $table->string('aem_fil', 250)->nullable();
            $table->string('aem_por', 250)->nullable();
            $table->string('aem_sen', 250)->nullable();
            $table->string('aem_pas', 250)->nullable();
            $table->string('aem_smt', 250)->nullable();
            $table->string('aem_to', 1000)->nullable();
            $table->boolean('enable');
            $table->timestamps();
            $table->boolean('aem_act')->default(true);
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
        Schema::dropIfExists('automatic_mails');
    }
}
