<?php

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert([
            'pve_dni' => "12345678",
            'pve_nam' => "proveedor 1",
            'pve_pho' => "0424-123456",
            'pve_mai' => "proveedor1@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'pve_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('providers')->insert([
            'pve_dni' => "12345679",
            'pve_nam' => "proveedor 2",
            'pve_pho' => "0424-123454",
            'pve_mai' => "proveedor1@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'pve_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('providers')->insert([
            'pve_dni' => "12345670",
            'pve_nam' => "proveedor 3",
            'pve_pho' => "0424-123450",
            'pve_mai' => "proveedor3@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'pve_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
