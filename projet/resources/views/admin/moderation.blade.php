<!-- resources/views/admin/moderation.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modération des Signalements - TalentMatcher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar with toggle function -->
        <div id="sidebar" class="w-16 bg-white border-r border-gray-200 transition-all duration-300">
            <div class="p-4 flex justify-center">
                <div class="flex-shrink-0 bg-blue-600 text-white p-2 rounded cursor-pointer" id="toggleSidebar">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
            
            <nav class="mt-6">
                <div class="flex flex-col items-center">
                    <a href="#" class="w-full flex justify-center py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-chart-line"></i>
                        <span class="ml-3 hidden sidebar-text">Tableau de bord</span>
                    </a>
                    
                    <a href="#" class="w-full flex justify-center py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-users"></i>
                        <span class="ml-3 hidden sidebar-text">Utilisateurs</span>
                    </a>
                    
                    <a href="#" class="w-full flex justify-center py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-briefcase"></i>
                        <span class="ml-3 hidden sidebar-text">Offres</span>
                    </a>
                    
                    <a href="#" class="w-full flex justify-center py-3 text-blue-600 border-l-4 border-blue-600">
                        <i class="fas fa-flag"></i>
                        <span class="ml-3 hidden sidebar-text">Modération</span>
                    </a>
                    
                    <a href="#" class="w-full flex justify-center py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-file-alt"></i>
                        <span class="ml-3 hidden sidebar-text">Candidatures</span>
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4">
                <h1 class="text-xl font-bold">Modération des Signalements</h1>
                
                <div class="flex items-center space-x-4">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                    
                    <button class="relative">
                        <i class="fas fa-bell text-gray-500"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden">
                        <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar" class="h-full w-full object-cover">
                    </div>
                </div>
            </header>
            
            <main class="p-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <!-- Nouveaux signalements -->
                    <div class="bg-white rounded-lg p-6 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-red-100">
                            <i class="fas fa-flag text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nouveaux signalements</p>
                            <p class="text-2xl font-bold">24</p>
                        </div>
                    </div>
                    
                    <!-- En attente -->
                    <div class="bg-white rounded-lg p-6 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-clock text-yellow-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">En attente</p>
                            <p class="text-2xl font-bold">12</p>
                        </div>
                    </div>
                    
                    <!-- Résolus aujourd'hui -->
                    <div class="bg-white rounded-lg p-6 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-check text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Résolus aujourd'hui</p>
                            <p class="text-2xl font-bold">8</p>
                        </div>
                    </div>
                    
                    <!-- Utilisateurs suspendus -->
                    <div class="bg-white rounded-lg p-6 shadow-sm flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-purple-100">
                            <i class="fas fa-ban text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Utilisateurs suspendus</p>
                            <p class="text-2xl font-bold">3</p>
                        </div>
                    </div>
                </div>
                
                <!-- Liste des signalements -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium">Liste des signalements</h2>
                    </div>
                    
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Motif</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Signalement 1 -->
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                            <img src="{{ asset('images/user1.jpg') }}" alt="Thomas Martin" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Thomas Martin</div>
                                            <div class="text-sm text-gray-500">thomas.m@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Contenu inapproprié</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">20 Jan 2025</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir détails">
                                            Voir détails
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Suspendre">
                                            Suspendre
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Signalement 2 -->
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                            <img src="{{ asset('images/user2.jpg') }}" alt="Sophie Bernard" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Sophie Bernard</div>
                                            <div class="text-sm text-gray-500">sophie.b@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Spam</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">19 Jan 2025</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Résolu</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir détails">
                                            Voir détails
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Suspendre">
                                            Suspendre
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Signalement 3 -->
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                            <img src="{{ asset('images/user3.jpg') }}" alt="Jean Dupont" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Jean Dupont</div>
                                            <div class="text-sm text-gray-500">jean.d@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Harcèlement</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">18 Jan 2025</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir détails">
                                            Voir détails
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Suspendre">
                                            Suspendre
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de 1 à 10 sur 97 résultats
                        </div>
                        
                        <div class="flex space-x-1">
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="px-3 py-1 border border-blue-600 bg-blue-600 rounded text-sm text-white">1</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-100">2</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-100">3</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            
            let sidebarExpanded = false;
            
            toggleButton.addEventListener('click', function() {
                sidebarExpanded = !sidebarExpanded;
                
                if (sidebarExpanded) {
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    
                    // Show text elements
                    sidebarTexts.forEach(text => {
                        text.classList.remove('hidden');
                    });
                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    
                    // Hide text elements
                    sidebarTexts.forEach(text => {
                        text.classList.add('hidden');
                    });
                }
            });
        });
    </script>
</body>
</html>