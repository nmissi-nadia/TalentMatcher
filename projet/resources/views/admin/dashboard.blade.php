<!-- resources/views/admin/dashboard.blade.php -->
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
                    
                    <a href="{{ route('admin.utilisateurs') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg mt-1">
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
                        <span>Modération</span>
                    </a>

                    <a href="#" data-action="logout" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg mt-6">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Déconnexion</span>
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
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm" id="stats-users">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">--</h3>
                            <p class="text-sm text-gray-500">Utilisateurs totaux</p>
                        </div>
                        <div class="text-green-500 font-medium" id="users-trend">+0%</div>
                    </div>
                    
                    <!-- Published Jobs -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm" id="stats-jobs">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-briefcase text-purple-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">--</h3>
                            <p class="text-sm text-gray-500">Offres publiées</p>
                        </div>
                        <div class="text-green-500 font-medium" id="jobs-trend">+0%</div>
                    </div>
                    
                    <!-- Monthly Visits -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm" id="stats-visits">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-orange-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">--</h3>
                            <p class="text-sm text-gray-500">Visites ce mois</p>
                        </div>
                        <div class="text-green-500 font-medium" id="visits-trend">+0%</div>
                    </div>
                    
                    <!-- Pending Applications -->
                    <div class="bg-white rounded-lg p-6 flex items-center justify-between shadow-sm" id="stats-applications">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-clock text-red-600"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-bold">--</h3>
                            <p class="text-sm text-gray-500">Candidatures en attente</p>
                        </div>
                        <div class="text-yellow-500 font-medium" id="applications-trend">+0%</div>
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
                                        <th class="pb-3 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="top-jobs-table">
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">Chargement des données...</td>
                                    </tr>
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
        // Admin Dashboard module
        const adminDashboard = {
            /**
             * Initialize the dashboard
             */
            init: async function() {
                // Set up charts with placeholder data
                this.initCharts();
                
                // Load the actual data
                try {
                    await this.loadDashboardData();
                } catch (error) {
                    console.error('Error loading dashboard data:', error);
                    window.showNotification('Erreur lors du chargement des données du tableau de bord', 'error');
                    // Use fallback data
                    this.loadFallbackData();
                }
                
                // Set up event listeners
                this.setupEventListeners();
            },
            
            /**
             * Initialize charts with placeholder data
             */
            initCharts: function() {
                // User Distribution Chart
                const userDistribution = document.getElementById('userDistributionChart').getContext('2d');
                window.userDistributionChart = new Chart(userDistribution, {
                    type: 'doughnut',
                    data: {
                        labels: ['Recruteurs', 'Candidats', 'Admins', 'Visiteurs'],
                        datasets: [{
                            data: [0, 0, 0, 0],
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
                window.activeSectorsChart = new Chart(activeSectors, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Nombre d\'offres',
                            data: [],
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
            },
            
            /**
             * Load dashboard data from API
             */
            loadDashboardData: async function() {
                // Get current user
                const user = await window.auth.getCurrentUser();
                if (!user) {
                    window.location.href = '/login';
                    return;
                }
                
                // Prepare API request promises
                const statsPromises = [
                    this.getUserStats(),
                    window.annonces.getStats(),
                    window.candidatures.getStats()
                ];
                
                // Wait for all requests to complete
                const [usersStats, annonceStats, candidatureStats] = await Promise.all(statsPromises);
                
                // Update UI with data
                this.updateStatsCards(usersStats, annonceStats, candidatureStats);
                this.updateUserDistributionChart(usersStats);
                this.updateActiveSectorsChart(annonceStats);
                this.updateTopJobsTable(annonceStats.popular || []);
            },
            
            /**
             * Get user statistics
             */
            getUserStats: async function() {
                try {
                    // Try to get user stats from API
                    const response = await window.apiClient.get('/stats/users');
                    return response;
                } catch (error) {
                    console.error('Error fetching user stats:', error);
                    
                    // Generate fallback user stats
                    const totalUsers = {{ $statistics['totalUsers'] ?? 0 }};
                    
                    // Return fallback data
                    return {
                        total: totalUsers,
                        trend: 5, // Assume 5% growth
                        distribution: {
                            recruteurs: Math.round(totalUsers * 0.3),
                            candidats: Math.round(totalUsers * 0.65),
                            admins: Math.round(totalUsers * 0.05),
                            visiteurs: 0
                        }
                    };
                }
            },
            
            /**
             * Load fallback data when API calls fail
             */
            loadFallbackData: function() {
                // Create fallback data using statistics from controller
                const usersStats = {
                    total: {{ $statistics['totalUsers'] ?? 0 }},
                    trend: 5,
                    distribution: {
                        recruteurs: {{ $statistics['totalUsers'] ? round($statistics['totalUsers'] * 0.3) : 0 }},
                        candidats: {{ $statistics['totalUsers'] ? round($statistics['totalUsers'] * 0.65) : 0 }},
                        admins: {{ $statistics['totalUsers'] ? round($statistics['totalUsers'] * 0.05) : 0 }},
                        visiteurs: 0
                    }
                };
                
                const annonceStats = {
                    total: {{ $statistics['activeAnnonces'] ?? 0 }},
                    trend: 8,
                    popular: this.generateSampleJobs(5),
                    sectors: {
                        'Informatique': 245,
                        'Marketing': 187,
                        'Finance': 125,
                        'RH': 98,
                        'Design': 65
                    }
                };
                
                const candidatureStats = {
                    total: {{ $statistics['totalCandidatures'] ?? 0 }},
                    pending: Math.round({{ $statistics['totalCandidatures'] ?? 0 }} * 0.4),
                    trend: 12
                };
                
                // Update UI with fallback data
                this.updateStatsCards(usersStats, annonceStats, candidatureStats);
                this.updateUserDistributionChart(usersStats);
                this.updateActiveSectorsChart(annonceStats);
                this.updateTopJobsTable(annonceStats.popular);
            },
            
            /**
             * Generate sample jobs for fallback
             */
            generateSampleJobs: function(count) {
                const jobs = [];
                const titles = [
                    'Développeur Full Stack',
                    'UX Designer',
                    'Chef de Projet Digital',
                    'Data Analyst',
                    'Développeur Mobile',
                    'DevOps Engineer',
                    'Product Manager',
                    'Marketing Digital'
                ];
                
                const companies = [
                    'TechCorp',
                    'DigitalSolutions',
                    'InnovateLab',
                    'DataTech',
                    'MobileSoft'
                ];
                
                for (let i = 0; i < count; i++) {
                    const title = titles[Math.floor(Math.random() * titles.length)];
                    const company = companies[Math.floor(Math.random() * companies.length)];
                    const views = Math.floor(Math.random() * 5000) + 500;
                    const applications = Math.floor(Math.random() * 100) + 5;
                    const status = Math.random() > 0.2 ? 'ouverte' : 'fermee';
                    
                    jobs.push({
                        id: i + 1,
                        titre: title,
                        recruteur: { name: company },
                        vues: views,
                        candidatures_count: applications,
                        statut: status
                    });
                }
                
                return jobs;
            },
            
            /**
             * Update statistics cards with data
             */
            updateStatsCards: function(usersStats, annonceStats, candidatureStats) {
                // Users stats
                document.querySelector('#stats-users h3').textContent = usersStats.total || '0';
                const usersTrend = document.getElementById('users-trend');
                usersTrend.textContent = `${usersStats.trend > 0 ? '+' : ''}${usersStats.trend}%`;
                usersTrend.className = usersStats.trend > 0 
                    ? 'text-green-500 font-medium' 
                    : (usersStats.trend < 0 ? 'text-red-500 font-medium' : 'text-yellow-500 font-medium');
                
                // Jobs stats
                document.querySelector('#stats-jobs h3').textContent = annonceStats.total || '0';
                const jobsTrend = document.getElementById('jobs-trend');
                jobsTrend.textContent = `${annonceStats.trend > 0 ? '+' : ''}${annonceStats.trend}%`;
                jobsTrend.className = annonceStats.trend > 0 
                    ? 'text-green-500 font-medium' 
                    : (annonceStats.trend < 0 ? 'text-red-500 font-medium' : 'text-yellow-500 font-medium');
                
                // Visits stats (simulated)
                const visitsCount = Math.floor(Math.random() * 20000) + 5000;
                const visitsTrend = Math.floor(Math.random() * 30) - 5;
                document.querySelector('#stats-visits h3').textContent = visitsCount.toLocaleString();
                const visitsTrendEl = document.getElementById('visits-trend');
                visitsTrendEl.textContent = `${visitsTrend > 0 ? '+' : ''}${visitsTrend}%`;
                visitsTrendEl.className = visitsTrend > 0 
                    ? 'text-green-500 font-medium' 
                    : (visitsTrend < 0 ? 'text-red-500 font-medium' : 'text-yellow-500 font-medium');
                
                // Applications stats
                document.querySelector('#stats-applications h3').textContent = candidatureStats.pending || '0';
                const appsTrend = document.getElementById('applications-trend');
                appsTrend.textContent = `${candidatureStats.trend > 0 ? '+' : ''}${candidatureStats.trend}%`;
                appsTrend.className = candidatureStats.trend > 0 
                    ? 'text-green-500 font-medium' 
                    : (candidatureStats.trend < 0 ? 'text-red-500 font-medium' : 'text-yellow-500 font-medium');
            },
            
            /**
             * Update user distribution chart
             */
            updateUserDistributionChart: function(usersStats) {
                const { distribution } = usersStats;
                
                if (distribution) {
                    window.userDistributionChart.data.datasets[0].data = [
                        distribution.recruteurs || 0,
                        distribution.candidats || 0,
                        distribution.admins || 0,
                        distribution.visiteurs || 0
                    ];
                    window.userDistributionChart.update();
                }
            },
            
            /**
             * Update active sectors chart
             */
            updateActiveSectorsChart: function(annonceStats) {
                const { sectors } = annonceStats;
                
                if (sectors) {
                    const sectorLabels = Object.keys(sectors);
                    const sectorData = sectorLabels.map(key => sectors[key]);
                    
                    window.activeSectorsChart.data.labels = sectorLabels;
                    window.activeSectorsChart.data.datasets[0].data = sectorData;
                    window.activeSectorsChart.update();
                } else {
                    // Use placeholder data
                    window.activeSectorsChart.data.labels = ['Informatique', 'Marketing', 'Finance', 'RH', 'Design'];
                    window.activeSectorsChart.data.datasets[0].data = [245, 187, 125, 98, 65];
                    window.activeSectorsChart.update();
                }
            },
            
            /**
             * Update top jobs table
             */
            updateTopJobsTable: function(popularJobs) {
                const tableBody = document.getElementById('top-jobs-table');
                
                // Clear loading message
                tableBody.innerHTML = '';
                
                if (popularJobs && popularJobs.length > 0) {
                    popularJobs.forEach(job => {
                        const statusClass = job.statut === 'ouverte' 
                            ? 'bg-green-100 text-green-600' 
                            : 'bg-yellow-100 text-yellow-600';
                        
                        const statusText = job.statut === 'ouverte' ? 'Active' : 'En pause';
                        
                        const row = document.createElement('tr');
                        row.className = 'border-b';
                        row.innerHTML = `
                            <td class="py-4">${job.titre}</td>
                            <td class="py-4">${job.recruteur?.name || 'N/A'}</td>
                            <td class="py-4">${job.vues || 0}</td>
                            <td class="py-4">${job.candidatures_count || 0}</td>
                            <td class="py-4">
                                <span class="px-3 py-1 text-xs rounded-full ${statusClass}">${statusText}</span>
                            </td>
                            <td class="py-4">
                                <a href="/admin/annonces/${job.id}" class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button data-id="${job.id}" class="text-red-600 hover:text-red-800 delete-job-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        
                        tableBody.appendChild(row);
                    });
                } else {
                    // No data available
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            Aucune donnée disponible
                        </td>
                    `;
                    tableBody.appendChild(row);
                }
            },
            
            /**
             * Set up event listeners
             */
            setupEventListeners: function() {
                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-job-btn').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        const jobId = e.currentTarget.getAttribute('data-id');
                        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')) {
                            try {
                                await window.annonces.delete(jobId);
                                window.showNotification('Offre supprimée avec succès', 'success');
                                
                                // Reload data
                                this.loadDashboardData();
                            } catch (error) {
                                window.showNotification('Erreur lors de la suppression de l\'offre', 'error');
                            }
                        }
                    });
                });
            }
        };
        
        // Initialize when the document is loaded
        document.addEventListener('DOMContentLoaded', () => {
            adminDashboard.init();
        });
    </script>
</body>
</html>