<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentMatcher - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ea530c;
        }
        .candidat {
            background-image: url('{{ asset('storage/images/backcand.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Style pour le fond du recruteur */
        .recruteur {
            background-image: url('{{ asset('storage/images/backrec.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

    </style>
</head>
<body class="bg-gray-100 @if(auth()->check()) {{ auth()->user()->role }} @endif">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r border-gray-200">
            <div class="p-4 flex items-center">
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="block">
                    <img src="{{ asset('storage/images/talentmatcherlog.png') }}" alt="Logo" class="w-44 h-14">
                </a>
            </div>
            <nav class="mt-8">
                <ul>
                    <!-- Dashboard -->
                    <li class="mb-2">
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 @if(request()->routeIs('dashboard')) bg-gray-100 @endif">
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Recruteur Links -->
                    @if(auth()->user()->role === 'recruteur')
                        <li class="mb-2">
                            <a href="{{ route('recruteur.offres') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 @if(request()->routeIs('recruteur.offres')) bg-gray-100 @endif">
                                <i class="fas fa-briefcase mr-3"></i>
                                Mes Offres
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('recruteur.annonces.create') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-plus-circle mr-3"></i>
                                Nouvelle Offre
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('recruteur.candidatures.index') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-users mr-3"></i>
                                Candidatures
                            </a>
                        </li>
                    @endif
                    
                    <!-- Candidat Links -->
                    @if(auth()->user()->role === 'candidat')
                        <li class="mb-2">
                            <a href="{{ route('candidat.offres') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-search mr-3"></i>
                                Rechercher Offres
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('candidat.profile') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-3"></i>
                                Mon Profil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('candidat.candidatures') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-list mr-3"></i>
                                Mes Candidatures
                            </a>
                        </li>
                    @endif
                    
                    <!-- Admin Links -->
                    @if(auth()->user()->role === 'admin')
                        <li class="mb-2">
                            <a href="{{ route('admin.utilisateurs') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-users-cog mr-3"></i>
                                Gestion Utilisateurs
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.tags') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tags mr-3"></i>
                                Gestion Tags_Catégories
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.categories') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
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
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                    <p class="text-sm text-gray-600">Bienvenue {{ auth()->user()->name }}</p>
                </div>
                
                <div class="flex items-center space-x-4">
                <form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#ea530c] hover:bg-[#d44a0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ea530c]">
        <i class="fas fa-sign-out-alt mr-2"></i>
        Déconnexion
    </button>
</form>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>