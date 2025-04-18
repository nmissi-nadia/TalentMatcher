<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentConnect | Plateforme de Recrutement</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-gray-200 shadow-md fixed w-full z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-[#ea580c]">TalentMatcher</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Ouvrir le menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white">
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0" aria-current="page">Accueil</a>
                    </li>
                    <li>
                        <a href="#fonctionnalites" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Fonctionnalités</a>
                    </li>
                    <li>
                        <a href="#pour-qui" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Pour qui</a>
                    </li>
                    <li>
                        <a href="#temoignages" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Témoignages</a>
                    </li>
                    <li>
                        <a href="#contact" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Contact</a>
                    </li>
                </ul>
            </div>
            @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-[#4f46e5] text-white rounded-md hover:bg-blue-700 transition duration-300 font-medium">Connexion</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#ea580c] text-white rounded-md hover:bg-blue-700 transition duration-300 font-medium">Inscription</a>
                            @endif
                        @endauth
                    </div>
                @endif
        </div>
    </nav>
    <!-- Hero Section -->
    <header class="pt-24 pb-12 md:pt-32 md:pb-20 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Trouvez le talent idéal ou l'emploi parfait</h1>
                <p class="text-xl mb-8">Une plateforme simple et efficace qui connecte candidats et recruteurs</p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="#" class="px-6 py-3 bg-white text-blue-600 rounded-md hover:bg-gray-100 transition duration-300 font-bold text-center">Je suis candidat</a>
                    <a href="#" class="px-6 py-3 bg-blue-800 text-white rounded-md hover:bg-blue-900 transition duration-300 font-bold text-center">Je suis recruteur</a>
                </div>
            </div>
            <div class="md:w-1/2 mt-10 md:mt-0">
                <img src="{{ asset('storage/images/img.png') }}" alt="Plateforme de recrutement illustration" class="rounded-lg shadow-xl">
            </div>
        </div>
    </header>
     <!-- Footer -->
     <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">TalentConnect</h3>
                    <p class="text-gray-400">La plateforme qui révolutionne le recrutement en connectant les meilleurs talents aux entreprises innovantes.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Accueil</a></li>
                        <li><a href="#fonctionnalites" class="hover:text-white transition duration-300">Fonctionnalités</a></li>
                        <li><a href="#pour-qui" class="hover:text-white transition duration-300">Pour qui</a></li>
                        <li><a href="#temoignages" class="hover:text-white transition duration-300">Témoignages</a></li>
                        <li><a href="#contact" class="hover:text-white transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Cookies</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">Restez informé de nos dernières actualités</p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" class="p-2 w-full rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                        <button type="submit" class="bg-blue-600 px-4 rounded-r-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 TalentConnect. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <script>
        // Navigation responsive
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle menu
            const menuButton = document.querySelector('[data-collapse-toggle="navbar-default"]');
            const menu = document.getElementById('navbar-default');
            
            if (menuButton) {
                menuButton.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
            
            // Smooth scroll pour les liens d'ancrage
            const anchorLinks = document.querySelectorAll('a[href^="#"]');
            
            anchorLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        
                        // Fermer le menu sur mobile après un clic
                        if (window.innerWidth < 768) {
                            menu.classList.add('hidden');
                        }
                    }
                });
            });
            
            // Animation au scroll
            function checkScroll() {
                const statsSection = document.querySelector('section:nth-of-type(1)');
                if (statsSection) {
                    const sectionPosition = statsSection.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;
                    
                    if (sectionPosition < screenPosition) {
                        animateCounters();
                        window.removeEventListener('scroll', checkScroll);
                    }
                }
            }
            
            window.addEventListener('scroll', checkScroll);
            checkScroll(); // Vérifier au chargement de la page
        });
    </script>
</body>
</html>