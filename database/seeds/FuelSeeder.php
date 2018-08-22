<?php

use Illuminate\Database\Seeder;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuels')->insert([
            'fue_oct' => "91",
            'fue_qua' => 50000,
            'use_nic' => 'sysadmin',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'tfu_id'=> 1,
            'fue_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('fuels')->insert([
            'fue_oct' => "Gasoil",
            'fue_qua' => 50000,
            'use_nic' => 'sysadmin',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'tfu_id'=> 2,
            'fue_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
