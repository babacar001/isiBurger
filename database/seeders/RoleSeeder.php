<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      //  Role::findByName('gestionnaire')->delete();
      //  Role::findByName('client')->delete();
     //   Role::findByName('super admin')->delete();

        Role::create(['name' => 'client', 'guard_name' => 'web']);
        Role::create(['name' => 'gestionnaire', 'guard_name' => 'web']);
    }
}
