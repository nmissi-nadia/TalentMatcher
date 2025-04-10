@extends('layouts.app')

@section('title', 'Tableau de Bord Candidat - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Stats Overview -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Applications Stats -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Candidatures actives
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="active-applications-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/candidat/applications') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir toutes les candidatures <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Completion -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Complétude du profil
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="profile-completion">
                                        <span id="profile-completion-percentage">--</span>%
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full">
                        <div class="h-2 bg-green-500 rounded-full" id="profile-completion-bar" style="width: 0%"></div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/profile') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Compléter mon profil <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job Matches -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Correspondances d'emploi
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="job-matches-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/candidat/jobs') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir les offres correspondantes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="px-4 sm:px-0 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Mes candidatures récentes</h3>
                <p class="mt-1 text-sm text-gray-500">Suivez l'état de vos dernières candidatures.</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Poste
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Entreprise
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="recent-applications-container">
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Chargement des candidatures...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ url('/candidat/applications') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Voir toutes mes candidatures <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <div class="px-4 sm:px-0 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Offres recommandées</h3>
                <p class="mt-1 text-sm text-gray-500">Des offres qui correspondent à votre profil.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6" id="recommended-jobs-container">
                <div class="col-span-3 text-center text-gray-500">
                    Chargement des recommandations...
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ url('/candidat/jobs') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Explorer toutes les offres <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        try {
            // Check if API client is available
            if (!window.apiClient || !window.candidatures || !window.annonces) {
                console.error('API client not available');
                showFallbackData();
                return;
            }
            
            // Load all data
            await loadDashboardData();
        } catch (error) {
            console.error('Error loading dashboard data:', error);
            showFallbackData();
            window.showNotification('Erreur lors du chargement des données', 'error');
        }
    });
    
    // Load all dashboard data from API
    async function loadDashboardData() {
        // Get current user
        const user = await window.auth.getCurrentUser();
        if (!user) {
            window.location.href = '/login';
            return;
        }
        
        // Load data in parallel
        const [applications, recommendations, profileInfo] = await Promise.all([
            loadApplications(),
            loadRecommendedJobs(),
            loadProfileInfo()
        ]);
        
        // Update UI with loaded data
        updateStats(applications, recommendations, profileInfo);
        displayRecentApplications(applications);
        displayRecommendedJobs(recommendations);
    }
    
    // Load applications data
    async function loadApplications() {
        try {
            return await window.candidatures.getAll();
        } catch (error) {
            console.error('Error loading applications:', error);
            return [];
        }
    }
    
    // Load recommended jobs based on user profile
    async function loadRecommendedJobs() {
        try {
            // In a real app, this would call a specific recommendation endpoint
            // For now, we'll just get all jobs
            const allJobs = await window.annonces.getAll();
            
            // Sort by most recently posted and take top 6
            return allJobs
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, 6);
        } catch (error) {
            console.error('Error loading recommended jobs:', error);
            return [];
        }
    }
    
    // Load profile completion information
    async function loadProfileInfo() {
        try {
            // In a real app, this would call a specific profile endpoint
            // For now, we'll simulate completion percentage
            return {
                completionPercentage: Math.floor(Math.random() * 30) + 70 // 70-100%
            };
        } catch (error) {
            console.error('Error loading profile info:', error);
            return { completionPercentage: 0 };
        }
    }
    
    // Update dashboard statistics
    function updateStats(applications, recommendations, profileInfo) {
        // Active applications count
        document.getElementById('active-applications-count').textContent = 
            applications.filter(app => app.statut !== 'rejetée').length;
        
        // Profile completion percentage
        const percentage = profileInfo.completionPercentage;
        document.getElementById('profile-completion-percentage').textContent = percentage;
        document.getElementById('profile-completion-bar').style.width = `${percentage}%`;
        
        // Job matches count
        document.getElementById('job-matches-count').textContent = recommendations.length;
    }
    
    // Display recent applications
    function displayRecentApplications(applications) {
        const container = document.getElementById('recent-applications-container');
        
        // Clear loading message
        container.innerHTML = '';
        
        if (applications.length === 0) {
            container.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Vous n'avez pas encore de candidatures.
                    </td>
                </tr>
            `;
            return;
        }
        
        // Sort by most recent first and take top 5
        const recentApplications = applications
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 5);
        
        recentApplications.forEach(application => {
            // Status badge styling
            let statusBadge = '';
            switch(application.statut) {
                case 'en_attente':
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>';
                    break;
                case 'entretien':
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Entretien</span>';
                    break;
                case 'acceptée':
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Acceptée</span>';
                    break;
                case 'rejetée':
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejetée</span>';
                    break;
                default:
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inconnu</span>';
            }
            
            // Format date
            const applicationDate = new Date(application.created_at);
            const formattedDate = applicationDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            
            // Create row
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${application.annonce?.titre || 'Poste inconnu'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${application.annonce?.recruteur?.name || 'Entreprise inconnue'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${formattedDate}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="/candidat/applications/${application.id}" class="text-blue-600 hover:text-blue-900 mr-3">Détails</a>
                    ${application.statut === 'en_attente' ? 
                        `<button data-id="${application.id}" class="text-red-600 hover:text-red-900 withdraw-btn">Retirer</button>` : 
                        ''}
                </td>
            `;
            
            container.appendChild(row);
        });
        
        // Add event listeners to withdraw buttons
        document.querySelectorAll('.withdraw-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const applicationId = this.getAttribute('data-id');
                if (confirm('Êtes-vous sûr de vouloir retirer cette candidature ?')) {
                    try {
                        await window.candidatures.withdraw(applicationId);
                        window.showNotification('Candidature retirée avec succès', 'success');
                        loadDashboardData(); // Reload data
                    } catch (error) {
                        window.showNotification('Erreur lors du retrait de la candidature', 'error');
                    }
                }
            });
        });
    }
    
    // Display recommended jobs
    function displayRecommendedJobs(jobs) {
        const container = document.getElementById('recommended-jobs-container');
        
        // Clear loading message
        container.innerHTML = '';
        
        if (jobs.length === 0) {
            container.innerHTML = `
                <div class="col-span-3 text-center text-gray-500">
                    Aucune offre recommandée pour le moment.
                </div>
            `;
            return;
        }
        
        jobs.forEach(job => {
            // Create job card
            const card = document.createElement('div');
            card.className = 'bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300';
            
            // Format date
            const postedDate = new Date(job.created_at);
            const formattedDate = postedDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            
            // Generate tags HTML if available
            let tagsHtml = '';
            if (job.tags && job.tags.length > 0) {
                tagsHtml = `
                    <div class="flex flex-wrap gap-2 mt-2">
                        ${job.tags.map(tag => 
                            `<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">${tag.nom}</span>`
                        ).join('')}
                    </div>
                `;
            }
            
            card.innerHTML = `
                <div class="p-4">
                    <h3 class="font-semibold text-lg text-gray-900 mb-1">${job.titre}</h3>
                    <p class="text-sm text-gray-600 mb-2">${job.recruteur?.name || 'Entreprise'}</p>
                    ${tagsHtml}
                    <p class="text-sm text-gray-500 mt-3 line-clamp-2 h-10 overflow-hidden">
                        ${job.description.substring(0, 100)}${job.description.length > 100 ? '...' : ''}
                    </p>
                </div>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Publié le ${formattedDate}</span>
                    <a href="/candidat/jobs/${job.id}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Voir <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            `;
            
            container.appendChild(card);
        });
    }
    
    // Show fallback data when API fails
    function showFallbackData() {
        // Stats
        document.getElementById('active-applications-count').textContent = '3';
        document.getElementById('profile-completion-percentage').textContent = '75';
        document.getElementById('profile-completion-bar').style.width = '75%';
        document.getElementById('job-matches-count').textContent = '12';
        
        // Recent applications
        document.getElementById('recent-applications-container').innerHTML = `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">Développeur Full Stack</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">TechCorp</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">12 mars 2025</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Détails</a>
                    <button class="text-red-600 hover:text-red-900">Retirer</button>
                </td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">UX Designer</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">DesignStudio</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">5 mars 2025</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Entretien</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="#" class="text-blue-600 hover:text-blue-900">Détails</a>
                </td>
            </tr>
        `;
        
        // Recommended jobs
        const recoContainer = document.getElementById('recommended-jobs-container');
        recoContainer.innerHTML = '';
        
        // Add 3 sample job cards
        const jobTitles = ['Développeur Front-end', 'Data Analyst', 'DevOps Engineer'];
        const companies = ['WebTech', 'DataCorp', 'CloudSys'];
        
        for (let i = 0; i < 3; i++) {
            const card = document.createElement('div');
            card.className = 'bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300';
            
            card.innerHTML = `
                <div class="p-4">
                    <h3 class="font-semibold text-lg text-gray-900 mb-1">${jobTitles[i]}</h3>
                    <p class="text-sm text-gray-600 mb-2">${companies[i]}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">JavaScript</span>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">React</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-3 line-clamp-2 h-10 overflow-hidden">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Sed euismod...
                    </p>
                </div>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Publié le 10 mars 2025</span>
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Voir <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            `;
            
            recoContainer.appendChild(card);
        }
    }
</script>
@endsection