<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentMatcher - @yield('title')</title>
    <script src="[https://cdn.tailwindcss.com](https://cdn.tailwindcss.com)"></script>
    <link rel="stylesheet" href="[https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">)
    <style>
        :root {
            --primary-color: #ea530c;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200">
            <div class="p-4 flex items-center">
                <h1 class="text-xl font-bold text-gray-800">TalentMatcher</h1>
            </div>
            <nav class="mt-8">
                <ul>
                    <!-- Dashboard -->
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}" 
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
                            <a href="{{ route('annonces.create') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-plus-circle mr-3"></i>
                                Nouvelle Offre
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('candidatures.index') }}" 
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
                            <a href="{{ route('candidat.profil') }}" 
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
                            <a href="{{ route('admin.users') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-users-cog mr-3"></i>
                                Gestion Utilisateurs
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.tags') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tags mr-3"></i>
                                Gestion Tags
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.categories') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-list-ul mr-3"></i>
                                Gestion Catégories
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
                    <div class="relative">
                        <a href="{{ route('logout') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#ea530c] hover:bg-[#d44a0b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ea530c]">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Déconnexion
                        </a>
                    </div>
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