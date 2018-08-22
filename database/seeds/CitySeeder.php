<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'cou_id' => 1,
            'cit_des' => 'Ciudad de Panama',
            'cit_act' => true,
        ]);
    }
}
