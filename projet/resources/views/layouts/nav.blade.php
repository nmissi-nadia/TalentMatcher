<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentMatcher - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #e8f0fe;
            --dark-blue: #001d35;
            --light-blue: #f5f8ff;
            --primary-orange: #ea530c;
            --secondary-orange: #fef0e8;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
                transition: transform 0.3s ease;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 40;
            }
            .sidebar-overlay.open {
                display: block;
            }
            .mobile-menu-button {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-100 @if(auth()->check()) {{ auth()->user()->role }} @endif">
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-button fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md md:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="sidebar w-64 bg-white border-r border-gray-200">
            <div class="p-4 flex items-center justify-between">
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="block">
                    <img src="{{ asset('storage/images/talentmatcherlog.png') }}" alt="Logo" class="w-44 h-14">
                </a>
                <button class="sidebar-close-button md:hidden p-1">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            <nav class="mt-8">
                <ul>
                    <!-- Dashboard -->
                    <li class="mb-2">
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 @if(request()->routeIs('dashboard')) bg-blue-50 text-blue-600 @endif">
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Recruteur Links -->
                    @if(auth()->user()->role === 'recruteur')
                        <li class="mb-2">
                            <a href="{{ route('recruteur.offres') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 @if(request()->routeIs('recruteur.offres')) bg-blue-50 text-blue-600 @endif">
                                <i class="fas fa-briefcase mr-3"></i>
                                Mes Offres
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('recruteur.annonces.create') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-plus-circle mr-3"></i>
                                Nouvelle Offre
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('recruteur.candidatures.index') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-users mr-3"></i>
                                Candidatures
                            </a>
                        </li>
                    @endif
                    
                    <!-- Candidat Links -->
                    @if(auth()->user()->role === 'candidat')
                        <li class="mb-2">
                            <a href="{{ route('candidat.offres') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-search mr-3"></i>
                                Rechercher Offres
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('candidat.profile') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-user mr-3"></i>
                                Mon Profil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('candidat.candidatures') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-list mr-3"></i>
                                Mes Candidatures
                            </a>
                        </li>
                    @endif
                    
                    <!-- Admin Links -->
                    @if(auth()->user()->role === 'admin')
                        <li class="mb-2">
                            <a href="{{ route('admin.utilisateurs') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-users-cog mr-3"></i>
                                Gestion Utilisateurs
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.annonces') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-briefcase mr-3"></i>
                                Gestion Offres
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.tags') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-tags mr-3"></i>
                                Gestion Tags_Catégories
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.moderation') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-list-ul mr-3"></i>
                                Modération et Signalement
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white border-b border-gray-200 flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-bold">@yield('title')</h1>
                    <p class="text-sm text-orange-200">Bienvenue {{ auth()->user()->name }}</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Script for mobile menu toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.mobile-menu-button');
            const sidebar = document.querySelector('.sidebar');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            const closeButton = document.querySelector('.sidebar-close-button');
            
            menuButton.addEventListener('click', function() {
                sidebar.classList.add('open');
                sidebarOverlay.classList.add('open');
            });
            
            closeButton.addEventListener('click', function() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
            });
            
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
            });
        });
    </script>

    @if(session('message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Message!',
            text: '{{ session('message') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#1a73e8'
        });
    </script>
    @endif
</body>
</html>