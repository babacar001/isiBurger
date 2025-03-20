<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
       // Permission::query()->delete();
        // Role::query()->delete();

        // Création des rôles
       // $clientRole = Role::create(['name' => 'client']);
     //   $gestionnaireRole = Role::create(['name' => 'gestionnaire']);
/*
        // Création de permissions
        $permissions = [
            'view catalogue',
            'create commande',
            'view own commandes',
            'manage burgers',
            'manage paiements',
            'view statistiques',
            'view all commandes',
            'update commande statut'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création du rôle 'super admin' et assignation de toutes les permissions
      //  $roleSuperAdmin = Role::create(['name' => 'super admin']);
      //  $roleSuperAdmin->givePermissionTo(Permission::all());

        // Permissions pour le rôle client
        $clientRole->givePermissionTo(['view catalogue', 'create commande', 'view own commandes']);

        // Permissions pour le rôle gestionnaire
        $gestionnaireRole->givePermissionTo([
            'manage burgers',
            'manage paiements',
            'view statistiques',
            'view all commandes',
            'update commande statut'
        ]);
*/

    }
}
