<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - TalentMatcher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-600 text-white p-2 rounded">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="ml-2 text-lg font-semibold">TalentMatcher</span>
                </div>
            </div>
            
            <nav class="mt-4">
                <div class="px-2">
                    <a href="#" class="flex items-center px-4 py-3 text-blue-600 bg-blue-50 rounded-lg">
                        <i class="fas fa-chart-line mr-3"></i>
                        <span>Tableau de bord</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-users mr-3"></i>
                        <span>Utilisateurs</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-briefcase mr-3"></i>
                        <span>Offres</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-file-alt mr-3"></i>
                        <span>Candidatures</span>
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-bold">Tableau de bord</h1>
                    <p class="text-sm text-gray-500">Vue d'ensemble de l'activité</p>
                </div>
                
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
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Users -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">2,451</h3>
                            <p class="text-sm text-gray-500">Utilisateurs totaux</p>
                        </div>
                        <div class="text-green-500 font-medium">+12%</div>
                    </div>
                    
                    <!-- Published Jobs -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-briefcase text-purple-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">847</h3>
                            <p class="text-sm text-gray-500">Offres publiées</p>
                        </div>
                        <div class="text-green-500 font-medium">+5%</div>
                    </div>
                    
                    <!-- Monthly Visits -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-orange-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">12,5K</h3>
                            <p class="text-sm text-gray-500">Visites ce mois</p>
                        </div>
                        <div class="text-green-500 font-medium">+16%</div>
                    </div>
                    
                    <!-- Pending Applications -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-clock text-red-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">156</h3>
                            <p class="text-sm text-gray-500">Candidatures en attente</p>
                        </div>
                        <div class="text-yellow-500 font-medium">+0%</div>
                    </div>
                </div>
                
                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- User Distribution -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-bold mb-6">Répartition des utilisateurs</h2>
                        <div class="flex justify-center">
                            <div class="w-64 h-64">
                                <canvas id="userDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Sectors -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-bold mb-6">Secteurs les plus actifs</h2>
                        <div>
                            <canvas id="activeSectorsChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Most Viewed Jobs -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="p-6">
                        <h2 class="text-lg font-bold mb-4">Offres les plus consultées</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-gray-500 border-b">
                                        <th class="pb-3 font-medium">Titre</th>
                                        <th class="pb-3 font-medium">Entreprise</th>
                                        <th class="pb-3 font-medium">Vues</th>
                                        <th class="pb-3 font-medium">Candidatures</th>
                                        <th class="pb-3 font-medium">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="py-4">Développeur Full Stack</td>
                                        <td class="py-4">TechCorp</td>
                                        <td class="py-4">1,245</td>
                                        <td class="py-4">48</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Active</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-4">Chef de Projet Marketing</td>
                                        <td class="py-4">MarketPro</td>
                                        <td class="py-4">987</td>
                                        <td class="py-4">32</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-4">UX Designer Senior</td>
                                        <td class="py-4">DesignHub</td>
                                        <td class="py-4">856</td>
                                        <td class="py-4">27</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">En pause</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-users mr-2"></i>
                        Gérer les utilisateurs
                    </button>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-briefcase mr-2"></i>
                        Gérer les offres
                    </button>
                    <button class="bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-file-alt mr-2"></i>
                        Voir les candidatures
                    </button>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // User Distribution Chart
        const userDistribution = document.getElementById('userDistributionChart').getContext('2d');
        new Chart(userDistribution, {
            type: 'doughnut',
            data: {
                labels: ['Recruteurs', 'Candidats', 'Admins', 'Visiteurs'],
                datasets: [{
                    data: [35, 45, 5, 15],
                    backgroundColor: ['#3b82f6', '#8b5cf6', '#ef4444', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Active Sectors Chart
        const activeSectors = document.getElementById('activeSectorsChart').getContext('2d');
        new Chart(activeSectors, {
            type: 'bar',
            data: {
                labels: ['Informatique', 'Marketing', 'Finance', 'RH', 'Design'],
                datasets: [{
                    label: 'Nombre d\'offres',
                    data: [245, 187, 125, 98, 65],
                    backgroundColor: '#3b82f6',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>