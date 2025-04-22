@extends('layouts.nav')

@section('content')
<div class="container mx-auto px-4 py-6">
   

    <!-- Profile Section -->
    <div class="bg-white rounded-lg shadow mt-6 p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
            <!-- Profile Picture -->
            <div>
                <img src="/path/to/profile-image.jpg" alt="Profile" class="w-32 h-32 rounded-full">
            </div>
            <!-- User Info -->
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold">Nadia Dupont</h2>
                <p class="text-gray-600">Développeuse Full Stack</p>
                <div class="mt-2 space-x-2">
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">HTML</span>
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">CSS</span>
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">JavaScript</span>
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">Laravel</span>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex space-x-4 mt-4 md:mt-0">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier Profil</button>
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Déconnexion</button>
            </div>
        </div>
    </div>

    <!-- User Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Personal Info -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-xl mb-4">Informations Personnelles</h3>
            <ul class="text-gray-700 space-y-2">
                <li><span class="font-semibold">Nom :</span> Nadia Dupont</li>
                <li><span class="font-semibold">Email :</span> nadia.dupont@example.com</li>
                <li><span class="font-semibold">Téléphone :</span> +33 6 12 34 56 78</li>
                <li><span class="font-semibold">Adresse :</span> Paris, France</li>
            </ul>
        </div>

        <!-- Skills -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-xl mb-4">Compétences</h3>
            <ul class="text-gray-700 space-y-2">
                <li>Création de sites dynamiques avec Laravel</li>
                <li>Conception de maquettes avec Tailwind CSS</li>
                <li>Intégration d'API REST et sécurité des données</li>
                <li>Gestion de bases de données MySQL</li>
            </ul>
        </div>
    </div>

    <!-- Resume and Saved offres -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Resume -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-xl mb-4">CV et Documents</h3>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Mon CV actuel</span>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Télécharger</button>
            </div>
        </div>

        <!-- Saved offres -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-xl mb-4">Offres sauvegardées</h3>
            <ul class="space-y-4">
                <li class="flex justify-between items-center">
                    <span>Développeur Frontend Senior</span>
                    <a href="#" class="text-blue-600 hover:underline">Voir l'offre</a>
                </li>
                <li class="flex justify-between items-center">
                    <span>Développeur Backend Laravel</span>
                    <a href="#" class="text-blue-600 hover:underline">Voir l'offre</a>
                </li>
                <li class="flex justify-between items-center">
                    <span>Lead Developer</span>
                    <a href="#" class="text-blue-600 hover:underline">Voir l'offre</a>
                </li>
            </ul>
        </div>
    </div>

   
</div>
@endsection
