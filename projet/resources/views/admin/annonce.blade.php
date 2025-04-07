<!-- resources/views/admin/offres.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Offres - TalentMatcher</title>
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
                    
                    <a href="#" class="w-full flex justify-center py-3 text-blue-600 border-l-4 border-blue-600">
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
                <h1 class="text-xl font-bold">Gestion des Offres</h1>
                
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
                <!-- Tab Navigation -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button id="tab-all" class="px-6 py-4 border-b-2 border-blue-600 text-blue-600 font-medium">
                                Toutes les offres
                            </button>
                            <button id="tab-active" class="px-6 py-4 text-gray-500 hover:text-gray-700">
                                Offres actives
                            </button>
                            <button id="tab-expired" class="px-6 py-4 text-gray-500 hover:text-gray-700">
                                Offres expirées
                            </button>
                        </nav>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre de l'offre</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Rechercher par titre" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Rechercher par entreprise" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <div class="relative">
                                <select class="w-full border border-gray-300 rounded-md py-2 px-3 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Tous les statuts</option>
                                    <option>Actif</option>
                                    <option>Expiré</option>
                                    <option>Brouillon</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de publication</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" class="pl-10 w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
                
                <!-- Jobs Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium">Liste des offres</h2>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                            <i class="fas fa-plus mr-2"></i>Nouvelle Offre
                        </button>
                    </div>
                
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Titre de l'offre</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date de publication</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Candidatures</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">Développeur Frontend React</div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">TechCorp</td>
                                <td class="px-6 py-4 text-gray-500">15 Jan 2025</td>
                                <td class="px-6 py-4 text-gray-500">12</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Actif</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir l'offre">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">UX Designer Senior</div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">DesignStudio</td>
                                <td class="px-6 py-4 text-gray-500">10 Jan 2025</td>
                                <td class="px-6 py-4 text-gray-500">8</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Expiré</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir l'offre">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800" title="Republier">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">Développeur Full Stack</div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">InnovSoft</td>
                                <td class="px-6 py-4 text-gray-500">08 Jan 2025</td>
                                <td class="px-6 py-4 text-gray-500">20</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Actif</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir l'offre">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">Administrateur Système</div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">SecureNet</td>
                                <td class="px-6 py-4 text-gray-500">05 Jan 2025</td>
                                <td class="px-6 py-4 text-gray-500">6</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" title="Voir l'offre">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800" title="Publier">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de 1 à 10 sur 45 offres
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
            
            // Tab functionality
            const tabAll = document.getElementById('tab-all');
            const tabActive = document.getElementById('tab-active');
            const tabExpired = document.getElementById('tab-expired');
            
            const activateTab = (activeTab, inactiveTabs) => {
                activeTab.classList.add('border-b-2', 'border-blue-600', 'text-blue-600');
                activeTab.classList.remove('text-gray-500');
                
                inactiveTabs.forEach(tab => {
                    tab.classList.remove('border-b-2', 'border-blue-600', 'text-blue-600');
                    tab.classList.add('text-gray-500');
                });
            };
            
            tabAll.addEventListener('click', function() {
                activateTab(tabAll, [tabActive, tabExpired]);
                // Ici vous pourriez ajouter du code pour filtrer les données
            });
            
            tabActive.addEventListener('click', function() {
                activateTab(tabActive, [tabAll, tabExpired]);
                // Ici vous pourriez ajouter du code pour filtrer les données
            });
            
            tabExpired.addEventListener('click', function() {
                activateTab(tabExpired, [tabAll, tabActive]);
                // Ici vous pourriez ajouter du code pour filtrer les données
            });
        });
    </script>
</body>
</html>
