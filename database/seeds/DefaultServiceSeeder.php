<?php

use Illuminate\Database\Seeder;

class DefaultServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB:: table('services')->truncate();
        DB:: table('service_actions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $services = [
          ["id" => 1, "description" => "User", "link" => "http://localhost/intraactiveops/api/gateway/public/api"],
          ["id" => 2, "description" => "Service", "link" => "http://localhost/intraactiveops/api/gateway/public/api"],
          ["id" => 3, "description" => "Auth", "link" => "http://localhost/intraactiveops/api/gateway/public/api"]
        ];
        $actions = [
          // USER
          ["id" => 1, "service_id" => 1, "description" => "Create User", "link" => "/create", "auth_required" => 1],
          ["id" => 2, "service_id" => 1, "description" => "Retrieve User", "link" => "/retrieve", "auth_required" => 1],
          ["id" => 3, "service_id" => 1, "description" => "Update User", "link" => "/update", "auth_required" => 1],
          ["id" => 4, "service_id" => 1, "description" => "Delete User", "link" => "/delete", "auth_required" => 1],
          // SERVICE
          ["id" => 5, "service_id" => 2, "description" => "Create Service", "link" => "/create", "auth_required" => 1],
          ["id" => 6, "service_id" => 2, "description" => "Retrieve Service", "link" => "/retrieve", "auth_required" => 1],
          ["id" => 7, "service_id" => 2, "description" => "Update Service", "link" => "/update", "auth_required" => 1],
          ["id" => 8, "service_id" => 2, "description" => "Delete Service", "link" => "/delete", "auth_required" => 1],
          // Auth
          ["id" => 9, "service_id" => 3, "description" => "Log In", "link" => "/login", "auth_required" => 0],
          ["id" => 10, "service_id" => 3, "description" => "User Details", "link" => "/user", "auth_required" => 0],
          ["id" => 11, "service_id" => 3, "description" => "Refresh", "link" => "/refresh", "auth_required" => 0],
          ["id" => 12, "service_id" => 3, "description" => "Log out", "link" => "/logout", "auth_required" => 0]
        ];
        DB::table('services') -> insert($services);
        DB::table('service_actions') -> insert($actions);
    }
}
