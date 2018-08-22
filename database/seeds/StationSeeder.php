<?php

use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->insert([
            'sts_nam' => "Estacion de servicio 1",
            'cit_id' => 1,
            'sts_dir' => "calle 22",
            'sts_pho' => "0424-4847402",
            'sts_mai' => "estacion1@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sts_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('stations')->insert([
            'sts_nam' => "Estacion de servicio 2",
            'cit_id' => 1,
            'sts_dir' => "calle 32",
            'sts_pho' => "0424-4577402",
            'sts_mai' => "estacion2@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sts_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('stations')->insert([
            'sts_nam' => "Estacion de servicio 3",
            'cit_id' => 1,
            'sts_dir' => "calle 22",
            'sts_pho' => "0424-4842102",
            'sts_mai' => "estacion3@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sts_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
