<?php
use Illuminate\Database\Seeder;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permisos para sysadmin
        DB::table('permissions')->insert([
            'name'=> 'index user',
            'slug'=>'index.user',
            'description' => 'listar usuarios',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 1,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update user',
            'slug'=>'update.user',
            'description' => 'actualizar usuario',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 2,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show user',
            'slug'=>'show.user',
            'description' => 'mostrar un usuario',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 3,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store user',
            'slug'=>'store.user',
            'description' => 'guardar un usuario',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 4,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete user',
            'slug'=>'delete.user',
            'description' => 'borrar usuario',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 5,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para account
        DB::table('permissions')->insert([
            'name'=> 'index account',
            'slug'=>'index.account',
            'description' => 'listar account',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 6,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update account',
            'slug'=>'update.account',
            'description' => 'actualizar account',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 7,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show account',
            'slug'=>'show.account',
            'description' => 'mostrar un account',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 8,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store account',
            'slug'=>'store.account',
            'description' => 'mostrar un account',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 9,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete account',
            'slug'=>'delete.account',
            'description' => 'borrar account',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 10,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para status
        DB::table('permissions')->insert([
            'name'=> 'index status',
            'slug'=>'index.status',
            'description' => 'listar status',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 11,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update status',
            'slug'=>'update.status',
            'description' => 'actualizar status',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 12,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show status',
            'slug'=>'show.status',
            'description' => 'mostrar un status',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 13,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store status',
            'slug'=>'store.status',
            'description' => 'guardar un status',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 14,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete status',
            'slug'=>'delete.status',
            'description' => 'borrar status',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 15,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para driver
        DB::table('permissions')->insert([
            'name'=> 'index driver',
            'slug'=>'index.driver',
            'description' => 'listar driver',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 16,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update driver',
            'slug'=>'update.driver',
            'description' => 'actualizar driver',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 17,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show driver',
            'slug'=>'show.driver',
            'description' => 'mostrar un driver',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 18,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store driver',
            'slug'=>'store.driver',
            'description' => 'guardar un driver',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 19,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete driver',
            'slug'=>'delete.driver',
            'description' => 'borrar driver',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 20,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);



        //permisos para brand_vehicle
        DB::table('permissions')->insert([
            'name'=> 'index brand_vehicle',
            'slug'=>'index.brand_vehicle',
            'description' => 'listar brand_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 21,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update brand_vehicle',
            'slug'=>'update.brand_vehicle',
            'description' => 'actualizar brand_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 22,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show brand_vehicle',
            'slug'=>'show.brand_vehicle',
            'description' => 'mostrar un brand_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 23,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store brand_vehicle',
            'slug'=>'store.brand_vehicle',
            'description' => 'guardar un brand_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 24,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete brand_vehicle',
            'slug'=>'delete.brand_vehicle',
            'description' => 'borrar brand_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 25,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para model_vehicle
        DB::table('permissions')->insert([
            'name'=> 'index model_vehicle',
            'slug'=>'index.model_vehicle',
            'description' => 'listar model_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 26,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update model_vehicle',
            'slug'=>'update.model_vehicle',
            'description' => 'actualizar model_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 27,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show model_vehicle',
            'slug'=>'show.model_vehicle',
            'description' => 'mostrar un model_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 28,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store model_vehicle',
            'slug'=>'store.model_vehicle',
            'description' => 'guardar un model_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 29,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete model_vehicle',
            'slug'=>'delete.model_vehicle',
            'description' => 'borrar model_vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 30,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para fleets
        DB::table('permissions')->insert([
            'name'=> 'index fleet',
            'slug'=>'index.fleet',
            'description' => 'listar fleet',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 31,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update fleet',
            'slug'=>'update.fleet',
            'description' => 'actualizar fleet',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 32,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show fleet',
            'slug'=>'show.fleet',
            'description' => 'mostrar un fleet',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 33,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store fleet',
            'slug'=>'store.fleet',
            'description' => 'guardar un fleet',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 34,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete fleet',
            'slug'=>'delete.fleet',
            'description' => 'borrar fleet',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 35,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para vehicles
        DB::table('permissions')->insert([
            'name'=> 'index vehicle',
            'slug'=>'index.vehicle',
            'description' => 'listar vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 36,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update vehicle',
            'slug'=>'update.vehicle',
            'description' => 'actualizar vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 37,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show vehicle',
            'slug'=>'show.vehicle',
            'description' => 'mostrar un vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 38,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store vehicle',
            'slug'=>'store.vehicle',
            'description' => 'guardar un vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 39,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete vehicle',
            'slug'=>'delete.vehicle',
            'description' => 'borrar vehicle',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 40,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para type_fuels
        DB::table('permissions')->insert([
            'name'=> 'index type_fuel',
            'slug'=>'index.type_fuel',
            'description' => 'listar type_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 41,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update type_fuel',
            'slug'=>'update.type_fuel',
            'description' => 'actualizar type_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 42,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show type_fuel',
            'slug'=>'show.type_fuel',
            'description' => 'mostrar un type_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 43,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store type_fuel',
            'slug'=>'store.type_fuel',
            'description' => 'guardar un type_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 44,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete type_fuel',
            'slug'=>'delete.type_fuel',
            'description' => 'borrar type_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 45,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para type_fuels
        DB::table('permissions')->insert([
            'name'=> 'index fuel',
            'slug'=>'index.fuel',
            'description' => 'listar fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 46,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update fuel',
            'slug'=>'update.fuel',
            'description' => 'actualizar fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 47,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show fuel',
            'slug'=>'show.fuel',
            'description' => 'mostrar un fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 48,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store fuel',
            'slug'=>'store.fuel',
            'description' => 'guardar un fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 49,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete fuel',
            'slug'=>'delete.fuel',
            'description' => 'borrar fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 50,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);



        //permisos para regional_configuration
        DB::table('permissions')->insert([
            'name'=> 'index regional_configuration',
            'slug'=>'index.regional_configuration',
            'description' => 'listar regional_configuration',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 51,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update regional_configuration',
            'slug'=>'update.regional_configuration',
            'description' => 'actualizar regional_configuration',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 52,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show regional_configuration',
            'slug'=>'show.regional_configuration',
            'description' => 'mostrar un regional_configuration',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 53,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store regional_configuration',
            'slug'=>'store.regional_configuration',
            'description' => 'guardar un regional_configuration',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 54,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete regional_configuration',
            'slug'=>'delete.regional_configuration',
            'description' => 'borrar regional_configuration',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 55,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para countrie
        DB::table('permissions')->insert([
            'name'=> 'index countrie',
            'slug'=>'index.countrie',
            'description' => 'listar countrie',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 56,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update countrie',
            'slug'=>'update.countrie',
            'description' => 'actualizar countrie',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 57,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show countrie',
            'slug'=>'show.countrie',
            'description' => 'mostrar un countrie',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 58,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store countrie',
            'slug'=>'store.countrie',
            'description' => 'guardar un countrie',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 59,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete countrie',
            'slug'=>'delete.countrie',
            'description' => 'borrar countrie',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 60,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para city
        DB::table('permissions')->insert([
            'name'=> 'index city',
            'slug'=>'index.city',
            'description' => 'listar city',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 61,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update city',
            'slug'=>'update.city',
            'description' => 'actualizar city',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 62,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show city',
            'slug'=>'show.city',
            'description' => 'mostrar un city',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 63,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store city',
            'slug'=>'store.city',
            'description' => 'guardar un city',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 64,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete city',
            'slug'=>'delete.city',
            'description' => 'borrar city',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 65,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para role
        DB::table('permissions')->insert([
            'name'=> 'index role',
            'slug'=>'index.role',
            'description' => 'listar role',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 66,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update role',
            'slug'=>'update.role',
            'description' => 'actualizar role',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 67,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show role',
            'slug'=>'show.role',
            'description' => 'mostrar un role',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 68,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store role',
            'slug'=>'store.role',
            'description' => 'guardar un role',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 69,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete role',
            'slug'=>'delete.role',
            'description' => 'borrar role',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 70,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para permission
        DB::table('permissions')->insert([
            'name'=> 'index permission',
            'slug'=>'index.permission',
            'description' => 'listar permission',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 71,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update permission',
            'slug'=>'update.permission',
            'description' => 'actualizar permission',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 72,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show permission',
            'slug'=>'show.permission',
            'description' => 'mostrar un permission',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 73,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store permission',
            'slug'=>'store.permission',
            'description' => 'guardar un permission',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 74,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete permission',
            'slug'=>'delete.permission',
            'description' => 'borrar permission',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 75,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para provider
        DB::table('permissions')->insert([
            'name'=> 'index provider',
            'slug'=>'index.provider',
            'description' => 'listar provider',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 76,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update provider',
            'slug'=>'update.provider',
            'description' => 'actualizar provider',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 77,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show provider',
            'slug'=>'show.provider',
            'description' => 'mostrar un provider',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 78,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store provider',
            'slug'=>'store.provider',
            'description' => 'guardar un provider',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 79,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete provider',
            'slug'=>'delete.provider',
            'description' => 'borrar provider',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 80,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para station
        DB::table('permissions')->insert([
            'name'=> 'index station',
            'slug'=>'index.station',
            'description' => 'listar station',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 81,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update station',
            'slug'=>'update.station',
            'description' => 'actualizar station',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 82,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show station',
            'slug'=>'show.station',
            'description' => 'mostrar un station',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 83,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store station',
            'slug'=>'store.station',
            'description' => 'guardar un station',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 84,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete station',
            'slug'=>'delete.station',
            'description' => 'borrar station',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 85,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para expenses
        DB::table('permissions')->insert([
            'name'=> 'index expense_fuel',
            'slug'=>'index.expense_fuel',
            'description' => 'listar expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 86,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update expense_fuel',
            'slug'=>'update.expense_fuel',
            'description' => 'actualizar expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 87,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show expense_fuel',
            'slug'=>'show.expense_fuel',
            'description' => 'mostrar un expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 88,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store expense_fuel',
            'slug'=>'store.expense_fuel',
            'description' => 'guardar un expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 89,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete expense_fuel',
            'slug'=>'delete.expense_fuel',
            'description' => 'borrar expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 90,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para detail_expense_fuel
        DB::table('permissions')->insert([
            'name'=> 'index detail_expense_fuel',
            'slug'=>'index.detail_expense_fuel',
            'description' => 'listar detail_expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 91,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update detail_expense_fuel',
            'slug'=>'update.detail_expense_fuel',
            'description' => 'actualizar detail_expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 92,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show detail_expense_fuel',
            'slug'=>'show.detail_expense_fuel',
            'description' => 'mostrar un detail_expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 93,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store detail_expense_fuel',
            'slug'=>'store.detail_expense_fuel',
            'description' => 'guardar un detail_expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 94,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete detail_expense_fuel',
            'slug'=>'delete.detail_expense_fuel',
            'description' => 'borrar detail_expense_fuel',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 95,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);



        //permisos para assingment
        DB::table('permissions')->insert([
            'name'=> 'index assignment',
            'slug'=>'index.assignment',
            'description' => 'listar assignment',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 96,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update assignment',
            'slug'=>'update.assignment',
            'description' => 'actualizar assignment',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 97,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show assignment',
            'slug'=>'show.assignment',
            'description' => 'mostrar un assignment',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 98,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store assignment',
            'slug'=>'store.assignment',
            'description' => 'guardar un assignment',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 99,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete assignment',
            'slug'=>'delete.assignment',
            'description' => 'borrar assignment',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 100,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //permisos para notification
        DB::table('permissions')->insert([
            'name'=> 'index notification',
            'slug'=>'index.notification',
            'description' => 'listar notification',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 101,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update notification',
            'slug'=>'update.notification',
            'description' => 'actualizar notification',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 102,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show notification',
            'slug'=>'show.notification',
            'description' => 'mostrar un notification',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 103,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store notification',
            'slug'=>'store.notification',
            'description' => 'guardar un notification',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 104,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete notification',
            'slug'=>'delete.notification',
            'description' => 'borrar notification',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 105,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos para automatic_mail
        DB::table('permissions')->insert([
            'name'=> 'index automatic_mail',
            'slug'=>'index.automatic_mail',
            'description' => 'listar automatic_mail',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 106,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update automatic_mail',
            'slug'=>'update.automatic_mail',
            'description' => 'actualizar automatic_mail',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 107,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show automatic_mail',
            'slug'=>'show.automatic_mail',
            'description' => 'mostrar un automatic_mail',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 108,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store automatic_mail',
            'slug'=>'store.automatic_mail',
            'description' => 'guardar un automatic_mail',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 109,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete automatic_mail',
            'slug'=>'delete.automatic_mail',
            'description' => 'borrar automatic_mail',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 110,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);



        //permisos para audit
        DB::table('permissions')->insert([
            'name'=> 'index audit',
            'slug'=>'index.audit',
            'description' => 'listar audit',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 111,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'update audit',
            'slug'=>'update.audit',
            'description' => 'actualizar audit',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 112,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'show audit',
            'slug'=>'show.audit',
            'description' => 'mostrar un audit',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 113,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'store audit',
            'slug'=>'store.audit',
            'description' => 'guardar un audit',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 114,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        //
        DB::table('permissions')->insert([
            'name'=> 'delete audit',
            'slug'=>'delete.audit',
            'description' => 'borrar audit',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 115,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);


        //permisos especiales
        //
        DB::table('permissions')->insert([
            'name'=> 'run backup',
            'slug'=>'run.backup',
            'description' => 'generar backup de la base de datos',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 116,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);

        //
        DB::table('permissions')->insert([
            'name'=> 'index.report',
            'slug'=>'index.report',
            'description' => 'ver los reportes',
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
        DB::table('permission_role')->insert([
            'permission_id'=> 117,
            'role_id'=> 1,
            'created_at'=> new DateTime,
            'updated_at'=> new DateTime
        ]);
    }
}