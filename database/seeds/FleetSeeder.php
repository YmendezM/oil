<?php

use Illuminate\Database\Seeder;

class FleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fleets')->insert([
            'fle_des' => 'aguaseo',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => 'sysadmin',
            'fle_act' => true,
            'acc_id' => 1
        ]);
    }
}
