<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Candidatures - TalentMatcher</title>
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
                    <a href="#" class="w-full flex justify-center py-3 text-blue-600 border-l-4 border-blue-600">
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
                <h1 class="text-xl font-bold">Gestion des Candidatures</h1>
                
                <div class="flex items-center space-x-4">
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
                <!-- Filters -->
                <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom du candidat</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Rechercher un candidat" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre de l'offre</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Rechercher une offre" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <div class="relative">
                                <select class="w-full border border-gray-300 rounded-md py-2 px-3 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Tous les statuts</option>
                                    <option>En attente</option>
                                    <option>Acceptée</option>
                                    <option>Refusée</option>
                                    <option>En cours de traitement</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Candidatures Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                            <img src="{{ asset('images/thomas.jpg') }}" alt="Thomas Martin" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Thomas Martin</div>
                                            <div class="text-sm text-gray-500">thomas.martin@email.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-900">Développeur Frontend</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">15 Jan 2025</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden mr-4">
                                            <img src="{{ asset('images/sophie.jpg') }}" alt="Sophie Bernard" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Sophie Bernard</div>
                                            <div class="text-sm text-gray-500">sophie.b@email.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-900">UX Designer</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Acceptée</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">12 Jan 2025</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de 1-10 sur 45 résultats
                        </div>
                        
                        <div class="flex space-x-1">
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600">Précédent</button>
                            <button class="px-3 py-1 border border-blue-600 bg-blue-600 rounded text-sm text-white">1</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600">2</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600">3</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-600">Suivant</button>
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