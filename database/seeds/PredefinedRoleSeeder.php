<?php

use Illuminate\Database\Seeder;

class PredefinedRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('role_access_lists')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $roles = [
          ['id' => 1, 'description' => 'superdoer', 'is_predefined' => 1],
          ['id' => 2, 'description' => 'developer', 'is_predefined' => 1],
          ['id' => 3, 'description' => 'analyst', 'is_predefined' => 1],
          ['id' => 50, 'description' => 'demo_user', 'is_predefined' => 1],
          ['id' => 100, 'description' => 'company_admin', 'is_predefined' => 1]
        ];
        $roleAccessList = [
          ["role_id" => 1, "service_action_registry_id" => 1],
          ["role_id" => 1, "service_action_registry_id" => 2],
          ["role_id" => 1, "service_action_registry_id" => 3],
          ["role_id" => 1, "service_action_registry_id" => 4],
          ["role_id" => 1, "service_action_registry_id" => 5],
          ["role_id" => 1, "service_action_registry_id" => 6],
          ["role_id" => 1, "service_action_registry_id" => 7],
          ["role_id" => 1, "service_action_registry_id" => 8]
        ];
        DB:: table('roles') -> insert($roles);
        DB:: table('role_access_lists') -> insert($roleAccessList);
    }
}
