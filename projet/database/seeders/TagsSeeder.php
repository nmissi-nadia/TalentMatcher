<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['nom' => 'PHP'],
            ['nom' => 'JavaScript'],
            ['nom' => 'Python'],
            ['nom' => 'Java'],
            ['nom' => 'C#'],
            ['nom' => 'React'],
            ['nom' => 'Vue.js'],
            ['nom' => 'Angular'],
            ['nom' => 'Node.js'],
            ['nom' => 'SQL'],
            ['nom' => 'MongoDB'],
            ['nom' => 'AWS'],
            ['nom' => 'Docker'],
            ['nom' => 'Git'],
            ['nom' => 'Agile'],
            ['nom' => 'Scrum'],
            ['nom' => 'HTML'],
            ['nom' => 'CSS'],
            ['nom' => 'Bootstrap'],
            ['nom' => 'Tailwind'],
            ['nom' => 'Photoshop'],
            ['nom' => 'Illustrator'],
            ['nom' => 'SEO'],
            ['nom' => 'SEM'],
            ['nom' => 'Google Analytics'],
            ['nom' => 'Data Analysis'],
            ['nom' => 'Machine Learning'],
            ['nom' => 'Cybersecurity'],
            ['nom' => 'Kubernetes'],
            ['nom' => 'Terraform'],
            ['nom' => 'Linux'],
            ['nom' => 'Windows'],
            ['nom' => 'Technical Support'],
            ['nom' => 'Project Management']
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}