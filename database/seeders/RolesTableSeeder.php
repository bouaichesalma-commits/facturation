<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'developer']);
        // Role::create(['name' => 'Secretaire']);
        // Role::create(['name' => 'Comptable']);
        //  user
        Permission::firstOrCreate(['name'=>'List of all users']);
        Permission::firstOrCreate(['name'=>'create user']);
        Permission::firstOrCreate(['name'=>'update user']);
        Permission::firstOrCreate(['name'=>'delete user']);
        Permission::firstOrCreate(['name'=>'show one user']);
        // client
        
        Permission::firstOrCreate(['name'=>'List of all client']);
        Permission::firstOrCreate(['name'=>'create client']);
        Permission::firstOrCreate(['name'=>'update client']); 
        Permission::firstOrCreate(['name'=>'delete client']);
        Permission::firstOrCreate(['name'=>'show one client']);
        
        //  articles
        
        Permission::firstOrCreate(['name'=>'List of all article']);
        Permission::firstOrCreate(['name'=>'create article']);
        Permission::firstOrCreate(['name'=>'update article']);
        Permission::firstOrCreate(['name'=>'delete article']);
        Permission::firstOrCreate(['name'=>'show one article']);

        // devis
        
        Permission::firstOrCreate(['name'=>'List of all devis']);
        Permission::firstOrCreate(['name'=>'create devis']);
        Permission::firstOrCreate(['name'=>'update devis']);
        Permission::firstOrCreate(['name'=>'delete devis']);
        Permission::firstOrCreate(['name'=>'show one devis']);
        Permission::firstOrCreate(['name'=>'imprimer devis']);
        // recu de paiement
        
        Permission::firstOrCreate(['name'=>'List of all recu de paiement']);
        Permission::firstOrCreate(['name'=>'create recu de paiement']);
        Permission::firstOrCreate(['name'=>'update recu de paiement']);
        Permission::firstOrCreate(['name'=>'delete recu de paiement']);
        Permission::firstOrCreate(['name'=>'show one recu de paiement']);
        Permission::firstOrCreate(['name'=>'imprimer recu de paiement']);

        // offre commerciale
        
        Permission::firstOrCreate(['name'=>'List of all offre commerciale']);
        Permission::firstOrCreate(['name'=>'create offre commerciale']);
        Permission::firstOrCreate(['name'=>'update offre commerciale']);
        Permission::firstOrCreate(['name'=>'delete offre commerciale']);
        Permission::firstOrCreate(['name'=>'show one offre commerciale']);
        Permission::firstOrCreate(['name'=>'imprimer offre commerciale']);
        // facture
        
        Permission::firstOrCreate(['name'=>'List of all facture']);
        Permission::firstOrCreate(['name'=>'create facture']);
        Permission::firstOrCreate(['name'=>'update facture']);
        Permission::firstOrCreate(['name'=>'delete facture']);
        Permission::firstOrCreate(['name'=>'show one facture']);
        Permission::firstOrCreate(['name'=>'imprimer facture']);
        //equipe
        Permission::firstOrCreate(['name'=>'List of all equipe']);



        // factur proformas
        
        Permission::firstOrCreate(['name'=>'List of all facture proformas']);
        Permission::firstOrCreate(['name'=>'create facture proformas']);
        Permission::firstOrCreate(['name'=>'update facture proformas']);
        Permission::firstOrCreate(['name'=>'delete facture proformas']);
        Permission::firstOrCreate(['name'=>'show one facture proformas']);
        Permission::firstOrCreate(['name'=>'imprimer facture proformas']);

        // utilisateur profile
        
        Permission::firstOrCreate(['name'=>'update profile']);
        Permission::firstOrCreate(['name'=>'update agence']);

        // notification 

        Permission::firstOrCreate(['name'=>'show notification']);

        //categorieequipe
        Permission::firstOrCreate(['name'=>'List of all cathegoriequipe']);
        Permission::firstOrCreate(['name'=>'show one cathegoriequipe']);
        Permission::firstOrCreate(['name'=>'update cathegoriequipe']);
        Permission::firstOrCreate(['name'=>'delete cathegoriequipe']);
        // equipe

        Permission::firstOrCreate(['name'=>'List of all equipe']);
        Permission::firstOrCreate(['name'=>'show one equipe']);
        Permission::firstOrCreate(['name'=>'update equipe']);
        Permission::firstOrCreate(['name'=>'delete equipe']);

        //categorieequipe
        Permission::firstOrCreate(['name'=>'List of all categorieprojets']);
        Permission::firstOrCreate(['name'=>'show one categorieprojets']);
        Permission::firstOrCreate(['name'=>'update categorieprojets']);
        Permission::firstOrCreate(['name'=>'delete categorieprojets']);

        // Permission::firstOrCreate(['name'=>'update profile']);
        
        Permission::firstOrCreate(['name'=>'no permission']);

    }
}
