@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">TalentMatcher</h1>
        <nav class="flex space-x-4">
            <a href="#" class="text-blue-600 hover:underline">Offres</a>
            <a href="#" class="text-blue-600 hover:underline">Entreprises</a>
            <a href="#" class="text-blue-600 hover:underline">Blog</a>
        </nav>
        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-200">
                <i class="fas fa-bell"></i>
            </button>
            <img src="/path/to/profile-image.jpg" alt="Profile" class="w-8 h-8 rounded-full">
        </div>
    </div>

    <!-- offre Details Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Main Content -->
        <main class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold">Développeur Full Stack Senior</h2>
                <p class="text-gray-600 mt-2">TechCorp • Paris, France • Temps plein</p>

                <div class="mt-4">
                    <h3 class="font-bold text-lg">Description du poste</h3>
                    <p class="mt-2 text-gray-700">
                        Nous recherchons un développeur Full Stack expérimenté pour rejoindre notre équipe dynamique...
                    </p>

                    <h3 class="font-bold text-lg mt-4">Responsabilités principales :</h3>
                    <ul class="list-disc ml-6 mt-2 text-gray-700">
                        <li>Développement d'applications web complexes</li>
                        <li>Collaboration avec les équipes produit et design</li>
                        <li>Code review et mentoring</li>
                    </ul>

                    <h3 class="font-bold text-lg mt-4">Compétences requises :</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">React</span>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">Node.js</span>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">TypeScript</span>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">MongoDB</span>
                    </div>
                </div>
            </div>

            <!-- Similar offres -->
            <div class="mt-6">
                <h3 class="font-bold text-xl mb-4">Offres similaires</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- offre Card -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-bold">Développeur Frontend Senior</h4>
                        <p class="text-gray-600 text-sm">WebTech Solutions • Paris, France</p>
                        <p class="text-blue-600 font-bold mt-2">45-60k€</p>
                    </div>
                    <!-- offre Card -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-bold">Développeur Backend Senior</h4>
                        <p class="text-gray-600 text-sm">DataTech • Lyon, France</p>
                        <p class="text-blue-600 font-bold mt-2">40-55k€</p>
                    </div>
                    <!-- offre Card -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-bold">Lead Developer</h4>
                        <p class="text-gray-600 text-sm">InnovTech • Bordeaux, France</p>
                        <p class="text-blue-600 font-bold mt-2">50-65k€</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <img src="/path/to/company-logo.jpg" alt="TechCorp Logo" class="w-16 h-16 rounded-full">
                <div class="ml-4">
                    <h3 class="font-bold text-lg">TechCorp</h3>
                    <p class="text-gray-600 text-sm">Technologies & Services</p>
                </div>
            </div>
            <p class="text-gray-700 mt-4">
                Leader dans le développement de solutions innovantes...
            </p>
            <a href="#" class="text-blue-600 mt-2 block hover:underline">Voir le profil de l'entreprise</a>

            <button class="bg-blue-600 text-white mt-4 w-full py-2 rounded-lg hover:bg-blue-700">
                Postuler maintenant
            </button>

            <div class="mt-4 flex justify-between">
                <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <i class="far fa-heart"></i>
                    <span>Sauvegarder</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-share-alt"></i>
                    <span>Partager</span>
                </button>
            </div>
        </aside>
    </div>

    <!-- Footer -->
    <footer class="mt-12 bg-gray-100 py-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <h4 class="font-bold">offreBoard</h4>
                <p class="text-gray-600">Trouvez votre prochain emploi dans la tech</p>
            </div>
            <div>
                <h4 class="font-bold">Pour les candidats</h4>
                <ul class="text-gray-600">
                    <li><a href="#" class="hover:underline">Parcourir les offres</a></li>
                    <li><a href="#" class="hover:underline">Entreprises</a></li>
                    <li><a href="#" class="hover:underline">Blog</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold">Pour les entreprises</h4>
                <ul class="text-gray-600">
                    <li><a href="#" class="hover:underline">Publier une offre</a></li>
                    <li><a href="#" class="hover:underline">Solutions RH</a></li>
                    <li><a href="#" class="hover:underline">Tarifs</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold">Suivez-nous</h4>
                <div class="flex space-x-4 text-gray-600 mt-2">
                    <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-blue-600"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
