<?php

use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12345678',
            'veh_pla' => 'AAA-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12345628',
            'veh_pla' => 'BBB-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12345679',
            'veh_pla' => 'CCC-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12345670',
            'veh_pla' => 'DDD-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12341678',
            'veh_pla' => 'EEE-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '16145628',
            'veh_pla' => 'FFF-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12317679',
            'veh_pla' => 'GGG-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);

        DB::table('assignments')->insert([
            'use_nic' => 'sysadmin',
            'dri_dni' => '12145680',
            'veh_pla' => 'HHH-123',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime,
            'ass_act' => true,
            'acc_id' => 1
        ]);
    }
}
