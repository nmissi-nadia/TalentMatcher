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