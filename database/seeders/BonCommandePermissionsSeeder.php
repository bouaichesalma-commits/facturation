<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BonCommandePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'List of all bon_commande',
            'show one bon_commande',
            'create bon_commande',
            'update bon_commande',
            'delete bon_commande',
            'imprimer bon_commande',
            'convert bon_commande'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign to role 1 assuming it's admin, or user id 1
        $role = Role::find(1);
        if ($role) {
            $role->givePermissionTo($permissions);
        }
        
        $role2 = Role::find(2); // In case there's another major role
        if ($role2) {
            $role2->givePermissionTo($permissions);
        }
    }
}
