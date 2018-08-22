<?php

use Illuminate\Database\Seeder;

class RegionalConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regional_configuration')->insert([
            'acc_id' => 1,
            'cou_id' => 1,
            'use_nic' => "sysadmin",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'rco_mon' => "Dolar",
            'rco_umv' => "Litros",
            'rco_ump' => "Kilos",
            'rco_uml' => "Metro",
            'rco_act'=> true
        ]);
    }
}
