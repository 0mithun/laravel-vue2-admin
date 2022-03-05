<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
                ['name'=>   'Admin','created_at'=> now()],
                ['name'=>   'Editor','created_at'=> now()],
                ['name'=>   'Viewer','created_at'=> now()],
        ]);
    }
}
