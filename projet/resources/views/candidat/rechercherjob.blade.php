@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">TalentMatcher</h1>
        <nav class="flex space-x-4">
            <a href="#" class="text-blue-600 hover:underline">Accueil</a>
            <a href="#" class="text-blue-600 hover:underline">Offres</a>
            <a href="#" class="text-blue-600 hover:underline">Entreprises</a>
        </nav>
        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-200">
                <i class="fas fa-bell"></i>
            </button>
            <img src="/path/to/profile-image.jpg" alt="Profile" class="w-8 h-8 rounded-full">
        </div>
    </div>

    <!-- Search Filters -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" placeholder="Mots-clés" class="border border-gray-300 rounded-lg p-2">
            <input type="text" placeholder="Localisation" class="border border-gray-300 rounded-lg p-2">
            <select class="border border-gray-300 rounded-lg p-2">
                <option>Type de contrat</option>
                <option>CDI</option>
                <option>CDD</option>
            </select>
            <select class="border border-gray-300 rounded-lg p-2">
                <option>Fourchette de salaire</option>
                <option>30k€ - 40k€</option>
                <option>40k€ - 50k€</option>
            </select>
            <button class="bg-blue-600 text-white rounded-lg p-2 md:col-span-4 hover:bg-blue-700">Rechercher</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="flex mt-6">
        <!-- Filters -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow hidden md:block">
            <h2 class="font-bold mb-4">Catégories d'emploi</h2>
            <div class="space-y-2">
                <label class="block"><input type="checkbox"> Développement</label>
                <label class="block"><input type="checkbox"> Design</label>
                <label class="block"><input type="checkbox"> Marketing</label>
            </div>

            <h2 class="font-bold mt-6 mb-4">Niveau d'expérience</h2>
            <div class="space-y-2">
                <label class="block"><input type="checkbox"> Débutant</label>
                <label class="block"><input type="checkbox"> Intermédiaire</label>
                <label class="block"><input type="checkbox"> Expert</label>
            </div>

            <h2 class="font-bold mt-6 mb-4">Entreprises</h2>
            <div class="space-y-2">
                <label class="block"><input type="checkbox"> Google</label>
                <label class="block"><input type="checkbox"> Microsoft</label>
                <label class="block"><input type="checkbox"> Apple</label>
            </div>
        </aside>

        <!-- Job Listings -->
        <main class="w-full md:w-3/4 md:ml-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold">203 offres trouvées</h2>
                <select class="border border-gray-300 rounded-lg p-2">
                    <option>Trier par : Plus récent</option>
                    <option>Salaire croissant</option>
                    <option>Salaire décroissant</option>
                </select>
            </div>

            <div class="mt-4 space-y-4">
                <!-- Job Card -->
                <div class="flex items-center bg-white p-4 rounded-lg shadow">
                    <img src="/path/to/image.jpg" alt="Company Logo" class="w-12 h-12 rounded-full">
                    <div class="ml-4 flex-1">
                        <h3 class="font-bold">Développeur Full Stack</h3>
                        <p class="text-gray-600">Google</p>
                        <div class="flex space-x-2 text-gray-500 text-sm">
                            <span>Paris</span>
                            <span>&bull;</span>
                            <span>CDI</span>
                            <span>&bull;</span>
                            <span>45k€ - 55k€</span>
                        </div>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Voir les détails</button>
                </div>

                <!-- Another Job Card -->
                <div class="flex items-center bg-white p-4 rounded-lg shadow">
                    <img src="/path/to/image2.jpg" alt="Company Logo" class="w-12 h-12 rounded-full">
                    <div class="ml-4 flex-1">
                        <h3 class="font-bold">UX Designer Senior</h3>
                        <p class="text-gray-600">Microsoft</p>
                        <div class="flex space-x-2 text-gray-500 text-sm">
                            <span>Lyon</span>
                            <span>&bull;</span>
                            <span>CDI</span>
                            <span>&bull;</span>
                            <span>40k€ - 50k€</span>
                        </div>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Voir les détails</button>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <nav class="flex space-x-2">
                    <button class="w-8 h-8 bg-gray-200 text-gray-600 rounded-lg">1</button>
                    <button class="w-8 h-8 bg-blue-600 text-white rounded-lg">2</button>
                    <button class="w-8 h-8 bg-gray-200 text-gray-600 rounded-lg">3</button>
                </nav>
            </div>
        </main>
    </div>
</div>
@endsection
