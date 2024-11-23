<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DiocesesAndPretresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 10 diocèses
        $villes = ['Abidjan', 'Bouaké', 'Daloa', 'Man'];

        for ($i = 1; $i <= 8; $i++) {

            $emplacement = $villes[array_rand($villes)];

            $dioceseId = DB::table('dioceses')->insertGetId([
                'diocese' => "Diocèse $i",
                'abreviation' => "DIO-$i",
                'emplacement' => $emplacement,
                'url_image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Créer 20 prêtres pour chaque diocèse
            for ($j = 1; $j <= 15; $j++) {
                DB::table('pretres')->insert([
                    'nom' => "Prêtre $j du Diocèse $i",
                    'prenoms' => "Prenom $j",
                    'matricule' => "MTR-$i-$j",
                    'dioceses_id' => $dioceseId,
                    'date_naissance' => now()->subYears(rand(25, 50))->toDateString(),
                    'lieu_naissance' => "Lieu de naissance $j",
                    'date_ordination_sacerdotale' => now()->subYears(rand(1, 20))->toDateString(),
                    'lieu_ordination_sacerdotale' => "Lieu d'ordination $j",
                    'diplome_etude_ecclesiastique' => "Diplôme Ecclesiastique $j",
                    'diplome_etude_profane' => "Diplôme Profane $j",
                    'numero_telephone' =>
                    rand(100000000, 999999999),
                    'adresse_electronique' => "pretre$j-diocese$i@example.com",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Ajouter un utilisateur super-admin
        DB::table('users')->insert([
            'nom' => 'super',
            'prenoms' => 'prenoms',
            'email' => 'admin@gmail.com',
            'phone' => '0000000000',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}