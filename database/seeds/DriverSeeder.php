<?php

use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            'dri_dni' => "12345678",
            'dri_com' => 30,
            'dri_nam' => "conductor 1",
            'dri_lic' => "L-12345678",
            'dri_pho' => "0424-123456",
            'dri_mai' => "conductor1@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 3,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12345628",
            'dri_com' => 30,
            'dri_nam' => "conductor 2",
            'dri_lic' => "L-12345628",
            'dri_pho' => "0424-1234561",
            'dri_mai' => "conductor2@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 4,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12345679",
            'dri_com' => 30,
            'dri_nam' => "conductor 3",
            'dri_lic' => "L-12345679",
            'dri_pho' => "0424-123457",
            'dri_mai' => "conductor3@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 3,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12345670",
            'dri_com' => 30,
            'dri_nam' => "conductor 4",
            'dri_lic' => "L-12345670",
            'dri_pho' => "0424-123458",
            'dri_mai' => "conductor4@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 4,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12341678",
            'dri_com' => 30,
            'dri_nam' => "conductor 5",
            'dri_lic' => "L-12344678",
            'dri_pho' => "0424-523456",
            'dri_mai' => "conductor5@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 3,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "16145628",
            'dri_com' => 30,
            'dri_nam' => "conductor 6",
            'dri_lic' => "L-12645628",
            'dri_pho' => "0424-1236561",
            'dri_mai' => "conductor6@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 4,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12317679",
            'dri_com' => 30,
            'dri_nam' => "conductor 7",
            'dri_lic' => "L-12375679",
            'dri_pho' => "0424-173457",
            'dri_mai' => "conductor7@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 3,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);

        DB::table('drivers')->insert([
            'dri_dni' => "12145680",
            'dri_com' => 30,
            'dri_nam' => "conductor 8",
            'dri_lic' => "L-12345870",
            'dri_pho' => "0424-123488",
            'dri_mai' => "conductor8@hotmail.com",
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'use_nic' => "sysadmin",
            'sta_id' => 4,
            'dri_act'=> true,
            'acc_id'=> 1
        ]);
    }
}
