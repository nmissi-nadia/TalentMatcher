<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentMatcher | Plateforme de Recrutement</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-gray-200 shadow-md fixed w-full z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="block">
                <img src="{{ asset('storage/images/talentmatcherlog.png') }}" alt="Logo" class="w-44 h-14">
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
                
            
            @if (Route::has('login'))
                    <li class="block py-2 pl-5 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                        @auth
                            <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-[#4f46e5] text-white rounded-md hover:bg-blue-700 transition duration-300 font-medium">Connexion</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#ea580c] text-white rounded-md hover:bg-blue-700 transition duration-300 font-medium">Inscription</a>
                            @endif
                        @endauth
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <header class="pt-24 pb-12 md:pt-32 md:pb-20 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-[#ea580e]">Trouvez le talent idéal ou l'emploi parfait</h1>
                <p class="text-xl mb-8">Une plateforme simple et efficace qui connecte candidats et recruteurs</p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="/login" class="px-6 py-3 bg-[#ea580c] text-blue-600 rounded-md hover:bg-gray-100 transition duration-300 font-bold text-center">Je suis candidat</a>
                    <a href="/login" class="px-6 py-3 bg-blue-800 text-white rounded-md hover:bg-blue-900 transition duration-300 font-bold text-center">Je suis recruteur</a>
                </div>
            </div>
            <div class="md:w-1/2 mt-10 md:mt-0">
                <img src="{{ asset('storage/images/img.png') }}" alt="Plateforme de recrutement" class="rounded-lg shadow-xl">
            </div>
        </div>
    </header>
    <!-- Stats -->
    <section class="py-12 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <p class="text-4xl font-bold text-blue-600 mb-2"><span id="candidatsCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Candidats inscrits</p>
                </div>
                <div class="p-6 rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <p class="text-4xl font-bold text-blue-600 mb-2"><span id="entreprisesCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Entreprises partenaires</p>
                </div>
                <div class="p-6 rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <p class="text-4xl font-bold text-blue-600 mb-2"><span id="matchCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Recrutements réussis</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Fonctionnalités -->
    <section id="fonctionnalites" class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos fonctionnalités</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4">Recherche intelligente</h3>
                    <p class="text-gray-600 text-center">Notre algorithme avancé trouve les meilleurs candidats pour vos postes ou les meilleures offres pour votre profil.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-tie text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4">Profils détaillés</h3>
                    <p class="text-gray-600 text-center">Créez un profil complet pour mettre en valeur vos compétences ou présenter votre entreprise.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4">Messagerie intégrée</h3>
                    <p class="text-gray-600 text-center">Communiquez directement avec les candidats ou les recruteurs sans quitter la plateforme.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Pour qui -->
    <section id="pour-qui" class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Une solution pour tous</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-gray-50 p-8 rounded-lg shadow-md border-t-4 border-blue-500">
                    <h3 class="text-2xl font-semibold mb-6 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-500"></i> Pour les candidats
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Créez un CV interactif et mettez en avant vos compétences</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Postulez en un clic aux offres d'emploi qui vous correspondent</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Recevez des recommandations personnalisées d'emplois</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 inline-block">Je m'inscris comme candidat</a>
                    </div>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg shadow-md border-t-4 border-indigo-500">
                    <h3 class="text-2xl font-semibold mb-6 flex items-center">
                        <i class="fas fa-building mr-2 text-indigo-500"></i> Pour les recruteurs
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Publiez facilement vos offres d'emploi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Trouvez des candidats qualifiés grâce à notre algorithme de matching</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-2 text-green-500"></i>
                            <span>Gérez tout le processus de recrutement dans un seul outil</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300 inline-block">Je m'inscris comme recruteur</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Témoignages -->
    <section id="temoignages" class="py-16 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Ils nous font confiance</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Sophie Martin</h4>
                            <p class="text-gray-600 text-sm">Développeuse Web</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Grâce à TalentMatcher, j'ai trouvé mon emploi idéal en seulement deux semaines. L'interface est intuitive et les offres parfaitement ciblées."</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Thomas Dubois</h4>
                            <p class="text-gray-600 text-sm">DRH, Innov'Tech</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Nous utilisons TalentMatcher pour tous nos recrutements. La qualité des profils et les outils de filtrage nous font gagner un temps précieux."</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Julie Leroux</h4>
                            <p class="text-gray-600 text-sm">Responsable Recrutement, GlobalSoft</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"L'algorithme de matching est impressionnant. Nous avons réduit notre temps de recrutement de 40% tout en améliorant la qualité des embauches."</p>
                    <div class="mt-4 flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to Action -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à booster votre carrière ou vos recrutements ?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Rejoignez des milliers d'utilisateurs satisfaits et commencez dès aujourd'hui à transformer votre approche du recrutement.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="px-8 py-4 bg-white text-blue-600 rounded-md hover:bg-gray-100 transition duration-300 font-bold">Je suis candidat</a>
                <a href="#" class="px-8 py-4 bg-blue-800 text-white rounded-md hover:bg-blue-900 transition duration-300 font-bold border border-white">Je suis recruteur</a>
            </div>
        </div>
    </section>
    <!-- Contact -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Contactez-nous</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-xl font-semibold mb-6">Envoyez-nous un message</h3>
                    <form>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 mb-2">Nom complet</label>
                            <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="sujet" class="block text-gray-700 mb-2">Sujet</label>
                            <select id="sujet" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Je suis candidat et j'ai une question</option>
                                <option>Je suis recruteur et j'ai une question</option>
                                <option>Je souhaite un devis entreprise</option>
                                <option>Autre demande</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 mb-2">Message</label>
                            <textarea id="message" rows="5" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Envoyer le message</button>
                    </form>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-6">Informations de contact</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Adresse</h4>
                                <p class="text-gray-600">123 Avenue de l'Innovation<br>46000 Safi, Maroc</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-phone text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Téléphone</h4>
                                <p class="text-gray-600">+212 600319784</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p class="text-gray-600">contact@talentmatcher.ma</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <h4 class="font-semibold mb-4">Suivez-nous</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-200 transition duration-300">
                                <i class="fab fa-facebook-f text-blue-600"></i>
                            </a>
                            <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-200 transition duration-300">
                                <i class="fab fa-twitter text-blue-600"></i>
                            </a>
                            <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-200 transition duration-300">
                                <i class="fab fa-linkedin-in text-blue-600"></i>
                            </a>
                            <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-200 transition duration-300">
                                <i class="fab fa-instagram text-blue-600"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- Footer -->
     <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                <img src="{{ asset('storage/images/talentmatcherlog.png') }}" alt="Logo" class="w-50 h-20">
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
                <p>&copy; 2025 TalentMatcher. Tous droits réservés.</p>
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
            checkScroll(); 
        });
        // Animation des statistiques
        function animateCounters() {
            const counters = document.querySelectorAll('#candidatsCount, #entreprisesCount, #matchCount');
            const speed = 200;
           
            const targetValues = {
                'candidatsCount': 150,
                'entreprisesCount': 25,
                'matchCount': 80
            };
           
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = targetValues[counter.id];
                    const count = +counter.innerText;
                    const increment = target / speed;
                   
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
               
                updateCount();
            });
        }
       
        
    </script>
</body>
</html>