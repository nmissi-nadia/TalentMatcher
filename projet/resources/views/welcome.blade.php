<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentMatcher | Plateforme de Recrutement</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #FFA502);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-gradient {
            background: #3454ff;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(46, 213, 115, 0.2);
        }
        .pulse-button {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-[#F8F9FA]">
    <!-- Navigation -->
    <nav class="bg-white border-gray-200 shadow-sm fixed w-full z-50">
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
                        <a href="#" class="block py-2 pl-3 pr-4 text-white bg-[#2ED573] rounded md:bg-transparent md:text-[#2ED573] md:p-0 md:font-bold" aria-current="page">Accueil</a>
                    </li>
                    <li>
                        <a href="#fonctionnalites" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#1E90FF] md:p-0">Fonctionnalités</a>
                    </li>
                    <li>
                        <a href="#pour-qui" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#1E90FF] md:p-0">Pour qui</a>
                    </li>
                    <li>
                        <a href="#temoignages" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#1E90FF] md:p-0">Témoignages</a>
                    </li>
                    <li>
                        <a href="#contact" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#1E90FF] md:p-0">Contact</a>
                    </li>
                
            
            @if (Route::has('login'))
                    <li class="block py-2 pl-5 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#1E90FF] md:p-0">
                        @auth
                            <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-[#1E90FF] text-white rounded-md hover:bg-[#187bcd] transition duration-300 font-medium">Connexion</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#FFA502] text-white rounded-md hover:bg-[#e59400] transition duration-300 font-medium ml-2">Inscription</a>
                            @endif
                        @endauth
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <header class="pt-24 pb-12 md:pt-32 md:pb-20 hero-gradient text-white">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Trouvez le talent idéal ou l'emploi parfait</h1>
                <p class="text-xl mb-8 opacity-90">Une plateforme simple et efficace qui connecte candidats et recruteurs</p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="/login" class="px-6 py-3 bg-gradient-to-r from-[#FF6B6B] to-[#FFA502] text-white rounded-md hover:opacity-90 transition-all duration-300 font-bold text-center pulse-button shadow-lg">Je suis candidat</a>
                <a href="/login" class="px-6 py-3 bg-gradient-to-r from-[#1E90FF] to-[#2ED573] text-white rounded-md hover:opacity-90 transition-all duration-300 font-bold text-center pulse-button shadow-lg">Je suis recruteur</a>
            </div>
            </div>
            <div class="md:w-1/2 mt-10 md:mt-0">
                <img src="{{ asset('storage/images/img.png') }}" alt="Plateforme de recrutement" class="rounded-lg shadow-2xl border-4 border-white/20">
            </div>
        </div>
    </header>
    <!-- Stats -->
    <section class="py-12 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 rounded-lg card-hover bg-gradient-to-br from-[#F8F9FA] to-white border border-gray-100">
                    <p class="text-4xl font-bold mb-2 text-[#1E90FF]"><span id="candidatsCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Candidats inscrits</p>
                </div>
                <div class="p-6 rounded-lg card-hover bg-gradient-to-br from-[#F8F9FA] to-white border border-gray-100">
                    <p class="text-4xl font-bold mb-2 text-[#2ED573]"><span id="entreprisesCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Entreprises partenaires</p>
                </div>
                <div class="p-6 rounded-lg card-hover bg-gradient-to-br from-[#F8F9FA] to-white border border-gray-100">
                    <p class="text-4xl font-bold mb-2 text-[#FFA502]"><span id="matchCount">0</span>k+</p>
                    <p class="text-gray-600 text-lg">Recrutements réussis</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Fonctionnalités -->
    <section id="fonctionnalites" class="py-16 bg-[#F8F9FA]">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-[#2C3E50]">Nos <span class="gradient-text">fonctionnalités</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 card-hover">
                    <div class="w-16 h-16 bg-[#E3F9FF] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-[#1E90FF] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-[#1E90FF]">Recherche intelligente</h3>
                    <p class="text-gray-600 text-center">Notre algorithme avancé trouve les meilleurs candidats pour vos postes ou les meilleures offres pour votre profil.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 card-hover">
                    <div class="w-16 h-16 bg-[#E5F7EF] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-tie text-[#2ED573] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-[#2ED573]">Profils détaillés</h3>
                    <p class="text-gray-600 text-center">Créez un profil complet pour mettre en valeur vos compétences ou présenter votre entreprise.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 card-hover">
                    <div class="w-16 h-16 bg-[#F5E9FF] rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-[#9B59B6] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-[#9B59B6]">Messagerie intégrée</h3>
                    <p class="text-gray-600 text-center">Communiquez directement avec les candidats ou les recruteurs sans quitter la plateforme.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Pour qui -->
    <section id="pour-qui" class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-[#2C3E50]">Une solution <span class="gradient-text">pour tous</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-[#F8F9FA] to-white p-8 rounded-xl shadow-md border-t-4 border-[#FF6B6B] card-hover">
                    <h3 class="text-2xl font-semibold mb-6 flex items-center text-[#FF6B6B]">
                        <i class="fas fa-user mr-3"></i> Pour les candidats
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Créez un CV interactif et mettez en avant vos compétences</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Postulez en un clic aux offres d'emploi qui vous correspondent</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Recevez des recommandations personnalisées d'emplois</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#" class="px-6 py-3 bg-gradient-to-r from-[#FF6B6B] to-[#FFA502] text-white rounded-md hover:shadow-lg transition duration-300 inline-block font-medium">Je m'inscris comme candidat</a>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#F8F9FA] to-white p-8 rounded-xl shadow-md border-t-4 border-[#1E90FF] card-hover">
                    <h3 class="text-2xl font-semibold mb-6 flex items-center text-[#1E90FF]">
                        <i class="fas fa-building mr-3"></i> Pour les recruteurs
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Publiez facilement vos offres d'emploi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Trouvez des candidats qualifiés grâce à notre algorithme de matching</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-[#2ED573]"></i>
                            <span class="text-gray-700">Gérez tout le processus de recrutement dans un seul outil</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#" class="px-6 py-3 bg-gradient-to-r from-[#1E90FF] to-[#2ED573] text-white rounded-md hover:shadow-lg transition duration-300 inline-block font-medium">Je m'inscris comme recruteur</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Témoignages -->
    <section id="temoignages" class="py-16 bg-[#F8F9FA]">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-[#2C3E50]">Ils nous font <span class="gradient-text">confiance</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md card-hover border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-[#FF6B6B] to-[#FFA502] flex items-center justify-center text-white font-bold">
                            SM
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-[#2C3E50]">Sophie Martin</h4>
                            <p class="text-gray-600 text-sm">Développeuse Web</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Grâce à TalentMatcher, j'ai trouvé mon emploi idéal en seulement deux semaines. L'interface est intuitive et les offres parfaitement ciblées."</p>
                    <div class="mt-4 flex text-[#FFA502]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md card-hover border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-[#1E90FF] to-[#2ED573] flex items-center justify-center text-white font-bold">
                            TD
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-[#2C3E50]">Thomas Dubois</h4>
                            <p class="text-gray-600 text-sm">DRH, Innov'Tech</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Nous utilisons TalentMatcher pour tous nos recrutements. La qualité des profils et les outils de filtrage nous font gagner un temps précieux."</p>
                    <div class="mt-4 flex text-[#FFA502]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md card-hover border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-[#9B59B6] to-[#1E90FF] flex items-center justify-center text-white font-bold">
                            JL
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-[#2C3E50]">Julie Leroux</h4>
                            <p class="text-gray-600 text-sm">Responsable Recrutement, GlobalSoft</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"L'algorithme de matching est impressionnant. Nous avons réduit notre temps de recrutement de 40% tout en améliorant la qualité des embauches."</p>
                    <div class="mt-4 flex text-[#FFA502]">
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
    <section class="py-16 bg-[#3454ff] text-white">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à booster votre carrière ou vos recrutements ?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">Rejoignez des milliers d'utilisateurs satisfaits et commencez dès aujourd'hui à transformer votre approche du recrutement.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="px-8 py-4 bg-white text-[#2ED573] rounded-lg hover:bg-gray-100 transition duration-300 font-bold shadow-lg hover:scale-[1.02]">Je suis candidat</a>
                <a href="#" class="px-8 py-4 bg-[#ea530c] text-white rounded-lg hover:bg-[#1565b7] transition duration-300 font-bold shadow-lg border border-white/20 hover:scale-[1.02]">Je suis recruteur</a>
            </div>
        </div>
    </section>
    <!-- Contact -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-[#2C3E50]">Contactez-<span class="gradient-text">nous</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-6 text-[#1E90FF]">Envoyez-nous un message</h3>
                    <form class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-700 mb-2 font-medium">Nom complet</label>
                            <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1E90FF] focus:border-transparent">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 mb-2 font-medium">Email</label>
                            <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1E90FF] focus:border-transparent">
                        </div>
                        <div>
                            <label for="sujet" class="block text-gray-700 mb-2 font-medium">Sujet</label>
                            <select id="sujet" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1E90FF] focus:border-transparent">
                                <option>Je suis candidat et j'ai une question</option>
                                <option>Je suis recruteur et j'ai une question</option>
                                <option>Je souhaite un devis entreprise</option>
                                <option>Autre demande</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="block text-gray-700 mb-2 font-medium">Message</label>
                            <textarea id="message" rows="5" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1E90FF] focus:border-transparent"></textarea>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#FF6B6B] to-[#FFA502] text-white rounded-lg hover:shadow-lg transition duration-300 font-medium w-full">Envoyer le message</button>
                    </form>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-6 text-[#1E90FF]">Informations de contact</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-[#E3F9FF] p-3 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt text-[#1E90FF]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#2C3E50]">Adresse</h4>
                                <p class="text-gray-600">123 Avenue de l'Innovation<br>46000 Safi, Maroc</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#E3F9FF] p-3 rounded-lg mr-4">
                                <i class="fas fa-phone text-[#1E90FF]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#2C3E50]">Téléphone</h4>
                                <p class="text-gray-600">+212 600319784</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#E3F9FF] p-3 rounded-lg mr-4">
                                <i class="fas fa-envelope text-[#1E90FF]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#2C3E50]">Email</h4>
                                <p class="text-gray-600">contact@talentmatcher.ma</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <h4 class="font-semibold mb-4 text-[#2C3E50]">Suivez-nous</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-[#E3F9FF] p-3 rounded-lg hover:bg-[#D0F0FF] transition duration-300 text-[#1E90FF]">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-[#E3F9FF] p-3 rounded-lg hover:bg-[#D0F0FF] transition duration-300 text-[#1E90FF]">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-[#E3F9FF] p-3 rounded-lg hover:bg-[#D0F0FF] transition duration-300 text-[#1E90FF]">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="bg-[#E3F9FF] p-3 rounded-lg hover:bg-[#D0F0FF] transition duration-300 text-[#1E90FF]">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- Footer -->
     <footer class="bg-[#3454ff] text-white py-12">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                <img src="{{ asset('storage/images/talentmatcherlog.png') }}" alt="Logo" class="w-50 h-20 mb-4">
                    <p class="text-white/80">La plateforme qui révolutionne le recrutement en connectant les meilleurs talents aux entreprises innovantes.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-white/80">
                        <li><a href="#" class="hover:text-white transition duration-300">Accueil</a></li>
                        <li><a href="#fonctionnalites" class="hover:text-white transition duration-300">Fonctionnalités</a></li>
                        <li><a href="#pour-qui" class="hover:text-white transition duration-300">Pour qui</a></li>
                        <li><a href="#temoignages" class="hover:text-white transition duration-300">Témoignages</a></li>
                        <li><a href="#contact" class="hover:text-white transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2 text-white/80">
                        <li><a href="#" class="hover:text-white transition duration-300">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Cookies</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-white/80 mb-4">Restez informé de nos dernières actualités</p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" class="p-3 w-full rounded-l-lg focus:outline-none focus:ring-2 focus:ring-[#FF6B6B] text-gray-800">
                        <button type="submit" class="bg-[#FF6B6B] px-4 rounded-r-lg hover:bg-[#e05c5c] transition duration-300">
                            <i class="fas fa-paper-plane text-white"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-8 text-center text-white/80">
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