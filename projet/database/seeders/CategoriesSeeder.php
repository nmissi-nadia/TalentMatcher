<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Développement Web'],
            ['nom' => 'Développement Mobile'],
            ['nom' => 'Design & UX'],
            ['nom' => 'Marketing Digital'],
            ['nom' => 'Data Science'],
            ['nom' => 'Cybersécurité'],
            ['nom' => 'DevOps'],
            ['nom' => 'Infrastructure'],
            ['nom' => 'Support Technique'],
            ['nom' => 'Management IT']
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}
