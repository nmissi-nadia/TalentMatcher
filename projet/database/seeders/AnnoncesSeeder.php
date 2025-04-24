<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Tag;
use App\Models\User;

class AnnoncesSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les recruteurs
        $recruteurs = User::where('role', 'recruteur')->get();
        
        // Récupérer les catégories
        $categories = Categorie::all();
        
        // Récupérer les tags
        $tags = Tag::all();

        // Créer 20 annonces
        foreach (range(1, 20) as $index) {
            $recruteur = $recruteurs->random();
            $categorie = $categories->random();
            
            $annonce = Annonce::create([
                'recruteur_id' => $recruteur->id,
                'categorie_id' => $categorie->id,
                'titre' => $this->getRandomTitle(),
                'description' => $this->getRandomDescription(),
                'salaire' => rand(2000, 6000),
                'location' => $this->getRandomLocation(),
                'competences' => $this->getRandomContractType(),
                'statut' => 'ouverte'
            ]);

            // Ajouter 2-4 tags aléatoires
            $randomTags = $tags->random(rand(2, 4));
            $annonce->tags()->attach($randomTags);
        }
    }

    private function getRandomTitle()
    {
        $titles = [
            'Développeur Full Stack',
            'Chef de Projet',
            'Analyste Business',
            'UX/UI Designer',
            'Chef de Produit',
            'DevOps Engineer',
            'Data Scientist',
            'Product Manager',
            'Scrum Master',
            'Business Analyst',
            'Développeur Frontend',
            'Développeur Backend',
            'Lead Developer',
            'Architecte Technique',
            'Consultant IT',
            'Chef de Projet Agile'
        ];
        return $titles[array_rand($titles)];
    }

    private function getRandomDescription()
    {
        $descriptions = [
            'Recherche un développeur expérimenté pour rejoindre notre équipe dynamique.',
            'Poste de chef de projet dans une entreprise innovante.',
            'Opportunité unique pour un analyste business passionné.',
            'Rejoignez notre équipe de design et créez des expériences utilisateur exceptionnelles.',
            'Poste de chef de produit dans une startup en pleine croissance.',
            'Cherchons un DevOps pour automatiser nos processus.',
            'Opportunité pour un Data Scientist passionné par l\'analyse de données.',
            'Recherche un Product Manager pour gérer nos produits numériques.',
            'Poste de Scrum Master dans une équipe Agile.',
            'Opportunité pour un Business Analyst dans une entreprise leader.',
            'Recherche un développeur Frontend expérimenté.',
            'Poste de développeur Backend dans une entreprise innovante.',
            'Cherchons un Lead Developer pour diriger notre équipe technique.',
            'Opportunité pour un Architecte Technique passionné.',
            'Poste de Consultant IT dans une entreprise leader.',
            'Recherche un Chef de Projet Agile expérimenté.'
        ];
        return $descriptions[array_rand($descriptions)];
    }

    private function getRandomLocation()
    {
        $locations = [
            'Casablanca',
            'Rabat',
            'Marrakech',
            'Tanger',
            'Fès',
            'Agadir',
            'Tétouan',
            'Oujda',
            'Kenitra',
            'Salé'
        ];
        return $locations[array_rand($locations)];
    }

    private function getRandomContractType()
    {
        $types = [
            'CDI',
            'CDD',
            'Stage',
            'Alternance',
            'Freelance',
            'Intérim'
        ];
        return $types[array_rand($types)];
    }
}