<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'sta_des' => "Activo",
            'sta_tab' => 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);

         DB::table('status')->insert([
            'sta_des' => "Bloqueado",
            'sta_tab' => 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('status')->insert([
            'sta_des' => "Activo",
            'sta_tab' => 2,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('status')->insert([
            'sta_des' => "En Reposo",
            'sta_tab' => 2,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('status')->insert([
            'sta_des' => "Activo",
            'sta_tab' => 3,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('status')->insert([
            'sta_des' => "En Mantenimiento",
            'sta_tab' => 3,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'sta_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
