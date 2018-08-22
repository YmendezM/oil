<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Audits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->increments('aud_id');
            $table->string('aud_pk', 255);
            $table->string('aud_use', 255);
            $table->string('aud_act', 255); //tipo de accion
            $table->string('aud_mod', 255);
            $table->ipAddress('aud_ip');
            $table->integer('acc_id');
            $table->timestamps();

            //fk
            $table->foreign('acc_id')->references('acc_id')->on('accounts')->onUpdate('cascade')->onDelete('restrict');
        });

        DB::connection()->getPdo()->exec("
            ALTER TABLE audits
            ADD aud_dbe hstore,
            ADD aud_dnew hstore;
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
