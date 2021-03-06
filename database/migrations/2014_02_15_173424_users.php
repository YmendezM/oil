<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('use_dni', 15)->unique();
            $table->string('use_nam', 50);
            $table->string('use_lna', 50)->nullable();
            $table->string('use_nic', 50)->unique();
            $table->string('email', 130)->nullable();
            $table->string('password', 250);
            //$table->string('use_tok', 100)->nullable();
            $table->timestamps();
            $table->boolean('use_act')->default(true);
            $table->integer('sta_id')->unsigned()->index();
            $table->integer('acc_id')->unsigned()->index();

            //fk
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
        Schema::dropIfExists('users');
    }
}
