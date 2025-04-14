@extends('layouts.app')

@section('title', 'Tableau de Bord Recruteur - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord recruteur</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Stats Overview -->
    <div class="px-4 py-4 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Jobs Stats -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total des offres
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="total-jobs-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/recruteur/jobs') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir toutes mes offres <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Jobs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Offres actives
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="active-jobs-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/recruteur/jobs?filter=active') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Gérer les offres actives <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Applications -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Candidatures reçues
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="total-applications-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/recruteur/candidates') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir les candidatures <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pending Reviews -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    En attente de traitement
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900" id="pending-reviews-count">
                                        --
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ url('/recruteur/candidates?filter=pending') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Traiter les candidatures <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4 sm:px-0 mb-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ url('/recruteur/jobs/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                <i class="fas fa-plus-circle mr-2"></i>
                Publier une nouvelle offre
            </a>
            <a href="{{ url('/recruteur/candidates?filter=pending') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                <i class="fas fa-user-check mr-2"></i>
                Traiter les candidatures
            </a>
            <a href="{{ url('/recruteur/jobs?filter=expired') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded-lg flex items-center justify-center transition">
                <i class="fas fa-history mr-2"></i>
                Gérer les offres expirées
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="px-4 sm:px-0 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Activités récentes</h3>
                <p class="mt-1 text-sm text-gray-500">Les derniers événements liés à votre activité de recrutement.</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <ul role="list" id="activity-list" class="-mb-8">
                        <li class="py-4 text-center text-gray-500">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                            Chargement des activités récentes...
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="px-4 sm:px-0 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Dernières candidatures</h3>
                <p class="mt-1 text-sm text-gray-500">Les candidatures les plus récentes à vos offres d'emploi.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Candidat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Poste
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="recent-applications-container" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                                Chargement des candidatures...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ url('/recruteur/candidates') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Voir toutes les candidatures <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs -->
    <div class="px-4 sm:px-0 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Offres actives</h3>
                    <p class="mt-1 text-sm text-gray-500">Vos offres d'emploi actuellement publiées.</p>
                </div>
                <a href="{{ url('/recruteur/jobs/create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter
                </a>
            </div>
            <div id="active-jobs-container" class="divide-y divide-gray-200">
                <div class="p-6 text-center text-gray-500">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                    Chargement des offres actives...
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ url('/recruteur/jobs') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Voir toutes les offres <i class="fas fa-arrow-right ml-1"></i>
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
            if (!window.apiClient || !window.annonces || !window.candidatures) {
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
        // const user = await window.auth.getCurrentUser();
        // if (!user) {
        //     window.location.href = '/login';
        //     return;
        // }
        
        // Load data in parallel
        const [jobs, applications, activities] = await Promise.all([
            loadJobs(),
            loadApplications(),
            loadActivities()
        ]);
        
        // Update UI with loaded data
        updateStats(jobs, applications);
        displayRecentApplications(applications);
        displayActiveJobs(jobs.filter(job => job.statut === 'ouverte'));
        displayActivities(activities);
    }
    
    // Load jobs data
    async function loadJobs() {
        try {
            // In a real app, we'd call a specific endpoint for the current recruiter's jobs
            return await window.annonces.getAll();
        } catch (error) {
            console.error('Error loading jobs:', error);
            return [];
        }
    }
    
    // Load applications data
    async function loadApplications() {
        try {
            // In a real app, we'd call a specific endpoint for the current recruiter's applications
            return await window.candidatures.getAll();
        } catch (error) {
            console.error('Error loading applications:', error);
            return [];
        }
    }
    
    // Load activities data
    async function loadActivities() {
        try {
            // In a real app, we'd call a specific endpoint for the current recruiter's activities
            // For now, we'll simulate activities
            return generateSampleActivities();
        } catch (error) {
            console.error('Error loading activities:', error);
            return [];
        }
    }
    
    // Update dashboard statistics
    function updateStats(jobs, applications) {
        // Total jobs
        document.getElementById('total-jobs-count').textContent = jobs.length;
        
        // Active jobs
        const activeJobs = jobs.filter(job => job.statut === 'ouverte');
        document.getElementById('active-jobs-count').textContent = activeJobs.length;
        
        // Total applications
        document.getElementById('total-applications-count').textContent = applications.length;
        
        // Pending applications
        const pendingApplications = applications.filter(app => app.statut === 'en_attente');
        document.getElementById('pending-reviews-count').textContent = pendingApplications.length;
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
                        Aucune candidature reçue pour le moment.
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
                case 'acceptee':
                    statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Acceptée</span>';
                    break;
                case 'rejetee':
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
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-500"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${application.candidat?.name || 'Candidat'}</div>
                            <div class="text-sm text-gray-500">${application.candidat?.email || 'Email non disponible'}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${application.annonce?.titre || 'Poste inconnu'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${formattedDate}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="/recruteur/candidates/${application.id}" class="text-blue-600 hover:text-blue-900">
                        Détails
                    </a>
                </td>
            `;
            
            container.appendChild(row);
        });
    }
    
    // Display active jobs
    function displayActiveJobs(jobs) {
        const container = document.getElementById('active-jobs-container');
        
        // Clear loading message
        container.innerHTML = '';
        
        if (jobs.length === 0) {
            container.innerHTML = `
                <div class="p-6 text-center text-gray-500">
                    <p>Vous n'avez aucune offre active pour le moment.</p>
                    <a href="/recruteur/jobs/create" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Publier une offre
                    </a>
                </div>
            `;
            return;
        }
        
        // Display active jobs (limited to 3)
        jobs.slice(0, 3).forEach(job => {
            // Format date
            const createdDate = new Date(job.created_at);
            const formattedDate = createdDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            
            // Generate tags HTML if available
            let tagsHtml = '';
            if (job.tags && job.tags.length > 0) {
                tagsHtml = `
                    <div class="mt-2 flex flex-wrap gap-2">
                        ${job.tags.slice(0, 3).map(tag => 
                            `<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">${tag.nom}</span>`
                        ).join('')}
                        ${job.tags.length > 3 ? 
                            `<span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">+${job.tags.length - 3} plus</span>` : 
                            ''}
                    </div>
                `;
            }
            
            // Calculate applications if available
            const applicationsCount = job.applications_count || 
                (job.applications ? job.applications.length : '0');
            
            const jobCard = document.createElement('div');
            jobCard.className = 'p-6 hover:bg-gray-50 transition-colors duration-200';
            jobCard.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-medium text-gray-900">
                            <a href="/recruteur/jobs/${job.id}" class="hover:text-blue-600">${job.titre}</a>
                        </h4>
                        <p class="mt-1 text-sm text-gray-500">Publié le ${formattedDate}</p>
                        ${tagsHtml}
                    </div>
                    <div class="mt-4 md:mt-0 flex flex-col items-end">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-user-friends mr-1"></i> ${applicationsCount} candidature(s)
                        </span>
                        <div class="mt-3 flex">
                            <a href="/recruteur/jobs/${job.id}/edit" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                                <i class="fas fa-edit mr-2"></i>
                                Modifier
                            </a>
                            <a href="/recruteur/candidates?job=${job.id}" class="ml-3 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                                <i class="fas fa-users mr-2"></i>
                                Voir candidats
                            </a>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(jobCard);
        });
    }
    
    // Display activities
    function displayActivities(activities) {
        const container = document.getElementById('activity-list');
        
        // Clear loading message
        container.innerHTML = '';
        
        if (activities.length === 0) {
            container.innerHTML = `
                <li class="py-4 text-center text-gray-500">
                    Aucune activité récente.
                </li>
            `;
            return;
        }
        
        activities.forEach((activity, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="relative pb-8">
                    ${index < activities.length - 1 ? '<span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>' : ''}
                    <div class="relative flex items-start space-x-3">
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full bg-${activity.color}-100 flex items-center justify-center ring-8 ring-white">
                                <i class="fas fa-${activity.icon} text-${activity.color}-600"></i>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <div class="text-sm">
                                    <span class="font-medium text-gray-900">${activity.title}</span>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">
                                    ${activity.date}
                                </p>
                            </div>
                            <div class="mt-2 text-sm text-gray-700">
                                <p>${activity.description}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(li);
        });
    }
    
    // Generate sample activities for demo
    function generateSampleActivities() {
        const now = new Date();
        
        return [
            {
                title: 'Nouvelle candidature reçue',
                description: 'Jean Dupont a postulé au poste de Développeur Full Stack.',
                date: formatRelativeTime(new Date(now.getTime() - 30 * 60000)), // 30 minutes ago
                icon: 'user-plus',
                color: 'green'
            },
            {
                title: 'Offre publiée',
                description: 'Vous avez publié une nouvelle offre pour un poste de UX Designer.',
                date: formatRelativeTime(new Date(now.getTime() - 3 * 3600000)), // 3 hours ago
                icon: 'briefcase',
                color: 'blue'
            },
            {
                title: 'Candidature mise à jour',
                description: 'Vous avez changé le statut de la candidature de Marie Martin à "Entretien".',
                date: formatRelativeTime(new Date(now.getTime() - 1 * 86400000)), // 1 day ago
                icon: 'exchange-alt',
                color: 'purple'
            },
            {
                title: 'Offre expirée',
                description: 'L\'offre pour le poste de Data Analyst a expiré.',
                date: formatRelativeTime(new Date(now.getTime() - 2 * 86400000)), // 2 days ago
                icon: 'clock',
                color: 'yellow'
            }
        ];
    }
    
    // Format relative time (e.g., "2 hours ago")
    function formatRelativeTime(date) {
        const now = new Date();
        const diffMs = now - date;
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHour = Math.floor(diffMin / 60);
        const diffDay = Math.floor(diffHour / 24);
        
        if (diffSec < 60) {
            return 'Il y a quelques secondes';
        } else if (diffMin < 60) {
            return `Il y a ${diffMin} minute${diffMin > 1 ? 's' : ''}`;
        } else if (diffHour < 24) {
            return `Il y a ${diffHour} heure${diffHour > 1 ? 's' : ''}`;
        } else if (diffDay < 30) {
            return `Il y a ${diffDay} jour${diffDay > 1 ? 's' : ''}`;
        } else {
            return date.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
    }
    
    // Show fallback data when API fails
    function showFallbackData() {
        // Stats
        document.getElementById('total-jobs-count').textContent = '8';
        document.getElementById('active-jobs-count').textContent = '5';
        document.getElementById('total-applications-count').textContent = '42';
        document.getElementById('pending-reviews-count').textContent = '12';
        
        // Activities
        displayActivities(generateSampleActivities());
        
        // Recent Applications
        const sampleApplications = [
            {
                id: 1,
                candidat: { name: 'Jean Dupont', email: 'jean.dupont@example.com' },
                annonce: { titre: 'Développeur Full Stack' },
                statut: 'en_attente',
                created_at: new Date(Date.now() - 30 * 60000).toISOString() // 30 minutes ago
            },
            {
                id: 2,
                candidat: { name: 'Marie Martin', email: 'marie.martin@example.com' },
                annonce: { titre: 'UX Designer' },
                statut: 'entretien',
                created_at: new Date(Date.now() - 3 * 3600000).toISOString() // 3 hours ago
            },
            {
                id: 3,
                candidat: { name: 'Pierre Durand', email: 'pierre.durand@example.com' },
                annonce: { titre: 'Chef de Projet' },
                statut: 'acceptee',
                created_at: new Date(Date.now() - 1 * 86400000).toISOString() // 1 day ago
            }
        ];
        displayRecentApplications(sampleApplications);
        
        // Active Jobs
        const sampleJobs = [
            {
                id: 1,
                titre: 'Développeur Full Stack',
                created_at: new Date(Date.now() - 3 * 86400000).toISOString(), // 3 days ago
                statut: 'ouverte',
                applications_count: 12,
                tags: [
                    { nom: 'JavaScript' },
                    { nom: 'React' },
                    { nom: 'PHP' }
                ]
            },
            {
                id: 2,
                titre: 'UX Designer',
                created_at: new Date(Date.now() - 7 * 86400000).toISOString(), // 7 days ago
                statut: 'ouverte',
                applications_count: 5,
                tags: [
                    { nom: 'UI/UX' },
                    { nom: 'Figma' },
                    { nom: 'Adobe XD' }
                ]
            },
            {
                id: 3,
                titre: 'Chef de Projet Digital',
                created_at: new Date(Date.now() - 10 * 86400000).toISOString(), // 10 days ago
                statut: 'ouverte',
                applications_count: 8,
                tags: [
                    { nom: 'Gestion de projet' },
                    { nom: 'Agile' },
                    { nom: 'Digital' }
                ]
            }
        ];
        displayActiveJobs(sampleJobs);
    }
</script>
@endsection