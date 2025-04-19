<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TalentMatcher - Plateforme de Recrutement')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    
    <!-- Custom Page Styles -->
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Main Nav -->
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-600 text-white p-2 rounded mr-2">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <span class="text-lg font-semibold">TalentMatcher</span>
                        </a>
                    </div>
                    
                    <nav class="hidden md:ml-6 md:flex md:space-x-8">
                        @auth
                            @if(auth()->user()->role === 'candidat')
                                <a href="{{ url('/candidat/dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('candidat/dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Tableau de bord
                                </a>
                                <a href="{{ url('/candidat/offres') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('candidat/offres*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Offres d'emploi
                                </a>
                                <a href="{{ url('/candidat/candidatures') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('candidat/candidatures*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Mes candidatures
                                </a>
                            @elseif(auth()->user()->role === 'recruteur')
                                <a href="{{ url('/recruteur/dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('recruteur/dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Tableau de bord
                                </a>
                                <a href="{{ url('/recruteur/offres') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('recruteur/offres*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Mes offres
                                </a>
                                <a href="{{ url('/recruteur/candidates') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('recruteur/candidates*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Candidats
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ url('/admin') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('admin') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Administration
                                </a>
                            @endif
                        @endauth
                        
                        @guest
                            <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('/') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Accueil
                            </a>
                            <a href="{{ url('/offres') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('offres*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Offres d'emploi
                            </a>
                            <a href="{{ url('/about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('about') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                À propos
                            </a>
                            <a href="{{ url('/contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('contact') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Contact
                            </a>
                        @endguest
                    </nav>
                </div>
                
                <!-- User Actions -->
                <div class="flex items-center">
                    @auth
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </button>
                            </div>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 role="menu" 
                                 aria-orientation="vertical" 
                                 aria-labelledby="user-menu-button"
                                 tabindex="-1">
                                
                                <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Mon profil
                                </a>
                                
                                <a href="#" data-action="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu (hidden by default) -->
        <div class="md:hidden" id="mobile-menu" x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 border-b border-gray-200">
                <span class="text-gray-600 font-medium">Menu</span>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
            
            <div x-show="open" class="pt-2 pb-3 space-y-1">
                @auth
                    @if(auth()->user()->role === 'candidat')
                        <a href="{{ url('/candidat/dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('candidat/dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Tableau de bord
                        </a>
                        <a href="{{ url('/candidat/offres') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('candidat/offres*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Offres d'emploi
                        </a>
                        <a href="{{ url('/candidat/candidatures') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('candidat/candidatures*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Mes candidatures
                        </a>
                    @elseif(auth()->user()->role === 'recruteur')
                        <a href="{{ url('/recruteur/dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('recruteur/dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Tableau de bord
                        </a>
                        <a href="{{ url('/recruteur/offres') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('recruteur/offres*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Mes offres
                        </a>
                        <a href="{{ url('/recruteur/candidates') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('recruteur/candidates*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Candidats
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ url('/admin') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('admin') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                            Administration
                        </a>
                    @endif
                    
                    <a href="{{ url('/profile') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        Mon profil
                    </a>
                    
                    <a href="#" data-action="logout" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        Déconnexion
                    </a>
                @else
                    <a href="{{ url('/') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('/') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Accueil
                    </a>
                    <a href="{{ url('/offres') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('offres*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Offres d'emploi
                    </a>
                    <a href="{{ url('/about') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('about') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        À propos
                    </a>
                    <a href="{{ url('/contact') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('contact') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Contact
                    </a>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="ml-auto bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
                                Inscription
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">TalentMatcher</h3>
                    <p class="text-gray-600 text-sm">La plateforme qui simplifie la mise en relation entre candidats et recruteurs.</p>
                </div>
                
                <div>
                    <h3 class="text-md font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600">Accueil</a></li>
                        <li><a href="{{ url('/offres') }}" class="text-gray-600 hover:text-blue-600">Offres d'emploi</a></li>
                        <li><a href="{{ url('/about') }}" class="text-gray-600 hover:text-blue-600">À propos</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-gray-600 hover:text-blue-600">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-md font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/terms') }}" class="text-gray-600 hover:text-blue-600">Conditions d'utilisation</a></li>
                        <li><a href="{{ url('/privacy') }}" class="text-gray-600 hover:text-blue-600">Politique de confidentialité</a></li>
                        <li><a href="{{ url('/cookies') }}" class="text-gray-600 hover:text-blue-600">Politique de cookies</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-md font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-blue-600">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-blue-600">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-blue-600">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-blue-600">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} TalentMatcher. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdowns and modals -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Scripts -->
    @yield('scripts')
    
    <script>
        // Initialize authentication events
        document.addEventListener('DOMContentLoaded', function() {
            // Logout functionality
            const logoutButtons = document.querySelectorAll('[data-action="logout"]');
            logoutButtons.forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    try {
                        // Use the auth module from app.js
                        if (window.auth) {
                            const result = await window.auth.logout();
                            if (result.success) {
                                window.location.href = '/login';
                            } else {
                                console.error('Logout failed:', result.message);
                                window.showNotification('Erreur lors de la déconnexion', 'error');
                            }
                        } else {
                            // Fallback to traditional form submission if API client not available
                            window.location.href = '/logout';
                        }
                    } catch (error) {
                        console.error('Logout error:', error);
                        window.showNotification('Erreur lors de la déconnexion', 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>