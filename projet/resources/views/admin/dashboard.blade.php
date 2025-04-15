<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord - TalentMatcher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-blue-600 bg-blue-50 rounded-lg">
                        <i class="fas fa-chart-line mr-3"></i>
                        <span>Tableau de bord</span>
                    </a>
                    
                    <a href="" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-users mr-3"></i>
                        <span>Utilisateurs</span>
                    </a>
                    
                    <a href="{{ route('admin.annonces') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-briefcase mr-3"></i>
                        <span>Offres</span>
                    </a>
                    
                    <a href="{{ route('admin.candidatures') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-file-alt mr-3"></i>
                        <span>Candidatures</span>
                    </a>

                    <a href="{{ route('admin.moderation') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-shield-alt mr-3"></i>
                        <span>Moderation</span>
                    </a>

                    <a href="" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
                        <i class="fas fa-trash-restore mr-3"></i>
                        <span>Utilisateurs supprimés</span>
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
                    <p class="text-sm text-gray-600">Bienvenue dans votre espace administrateur</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ $progression['users']['percentage'] }}% des utilisateurs actifs
                        </span>
                    </div>
                </div>
            </header>

            <main class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Users -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
                            <p class="text-gray-600">Utilisateurs actifs</p>
                        </div>
                        <i class="fas fa-users text-blue-600 text-4xl"></i>
                    </div>

                    <!-- Active Jobs -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $activeAnnonces }}</h3>
                            <p class="text-gray-600">Offres actives</p>
                        </div>
                        <i class="fas fa-briefcase text-green-600 text-4xl"></i>
                    </div>

                    <!-- New Candidates -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $newCandidates }}</h3>
                            <p class="text-gray-600">Nouveaux candidats (30j)</p>
                        </div>
                        <i class="fas fa-user-plus text-purple-600 text-4xl"></i>
                    </div>

                    <!-- Total Applications -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $totalCandidatures }}</h3>
                            <p class="text-gray-600">Candidatures totales</p>
                        </div>
                        <i class="fas fa-file-alt text-yellow-600 text-4xl"></i>
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
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consultations</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($topJobs as $job)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $job->titre }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $job->recruteur->name ?? 'Non spécifié' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $job->views_count }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->statut === 'ouverte' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($job->statut) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.deleteJob', $job->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.annonce', $job->id) }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.utilisateurs') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-users mr-2"></i>
                        Gérer les utilisateurs
                    </a>
                    <a href="{{ route('admin.annonces') }}" class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-briefcase mr-2"></i>
                        Gérer les offres
                    </a>
                    <a href="{{ route('admin.candidatures') }}" class="bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-file-alt mr-2"></i>
                        Voir les candidatures
                    </a>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Chart configuration
        const userDistributionChart = new Chart(document.getElementById('userDistributionChart'), {
            type: 'pie',
            data: {
                labels: ['Utilisateurs actifs', 'Utilisateurs supprimés'],
                datasets: [{
                    data: [{{ $progression['users']['total'] }}, {{ $progression['users']['deleted'] }}],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' (' + Math.round((context.parsed / ({{ $progression['users']['total'] }} + {{ $progression['users']['deleted'] }}) * 100)) + '%)';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        const activeSectorsChart = new Chart(document.getElementById('activeSectorsChart'), {
            type: 'bar',
            data: {
                labels: ['Offres actives', 'Offres inactives'],
                datasets: [{
                    label: 'Nombre d\'offres',
                    data: [{{ $progression['annonces']['active'] }}, {{ $progression['annonces']['total'] - $progression['annonces']['active'] }}],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: {
                responsive: true,
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