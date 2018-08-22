<?php

use Illuminate\Database\Seeder;

class TypeFuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_fuels')->insert([
            'tfu_des' => "Gasolina",
            'use_nic' => "sysadmin",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'tfu_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('type_fuels')->insert([
            'tfu_des' => "Gasoil",
            'use_nic' => "sysadmin",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'tfu_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
