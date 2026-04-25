<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Create an admin user
        
        $developerUser = \App\Models\User::factory()->create([
            'nom' => 'Developer',
            'prenom' => 'User',
            'email' => 'developer@example.com',
        ]);

        $ComptableUser = \App\Models\User::factory()->create([
            'nom' => 'Comptable',
            'prenom' => 'User',
            'email' => 'Comptable@example.com',
        ]);
        
        $SecretaireUser = \App\Models\User::factory()->create([
            'nom' => 'Secretaire',
            'prenom' => 'User',
            'email' => 'Secretaire@example.com',
        ]);
        // Assign the 'admin' role to the admin user
        User::find(1)->assignRole('admin');


        // Assign the 'developer' role to the developer user
        $developerUser->assignRole('developer');
        
        // Assign the 'Secretaire' role to the Secretaire user
        $SecretaireUser->assignRole('Secretaire');

        // Assign the 'Comptable' role to the Comptable user
        $ComptableUser->assignRole('Comptable');
    }
}
