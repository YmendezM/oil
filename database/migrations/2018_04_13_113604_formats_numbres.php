<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FormatsNumbres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec("
        create or replace function public.format_numbers(xvalor numeric) returns varchar 
        LANGUAGE plpgsql as $$
            declare 
              xcad character varying; xlon integer; xpos integer; xres character varying; xdev character varying;
            begin
               xcad := cast(xvalor as varchar);
              --xcad := to_char(xvalor,'9999999999D9999');
              xlon := length(xcad);
              xpos := strpos(xcad,'.');
              --xpos = xpos +1;
              xres := substr(xcad, xpos+1, xlon);
             -- raise notice '%', xres;
              if xres = '0000' or xres='000' or xres= '00' or xres = '0' then
                xdev := substr(xcad, 1, xpos-1);
                else
                xres := substr(xcad, xpos+3, xlon);
                if xres = '00' then
                    xdev := substr(xcad, 1, xpos+2);
                    else
                    xdev := xcad;
                end if;
              end if;
             return xdev;
           end;
           $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formats_numbers');
    }
}
