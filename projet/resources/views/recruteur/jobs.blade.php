@extends('layouts.app')

@section('title', 'Gestion des Offres - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des offres d'emploi</h1>
            <p class="mt-1 text-sm text-gray-500">Gérez vos annonces et suivez les candidatures.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ url('/recruteur/jobs/create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i>
                Publier une offre
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Filters -->
    <div class="px-4 sm:px-0 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-4">
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Tous les statuts</option>
                            <option value="ouverte">Ouvertes</option>
                            <option value="fermee">Fermées</option>
                            <option value="archivee">Archivées</option>
                            <option value="brouillon">Brouillons</option>
                        </select>
                    </div>
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700">Date</label>
                        <select id="date-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                            <option value="quarter">Ce trimestre</option>
                        </select>
                    </div>
                    <div>
                        <label for="applications-filter" class="block text-sm font-medium text-gray-700">Candidatures</label>
                        <select id="applications-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Toutes</option>
                            <option value="with">Avec candidatures</option>
                            <option value="without">Sans candidature</option>
                        </select>
                    </div>
                    <div>
                        <label for="search-jobs" class="block text-sm font-medium text-gray-700">Recherche</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-jobs" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher une offre...">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="apply-filters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-filter mr-2"></i>
                        Appliquer les filtres
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jobs List -->
    <div class="px-4 sm:px-0">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Vos offres d'emploi</h3>
                    <div class="flex-1 flex justify-end items-center">
                        <span id="jobs-count" class="text-sm text-gray-500">0 offres</span>
                        <div class="ml-4">
                            <select id="sort-jobs" class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="newest">Plus récentes</option>
                                <option value="oldest">Plus anciennes</option>
                                <option value="applications">Plus de candidatures</option>
                                <option value="title">Titre (A-Z)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="jobs-container" class="divide-y divide-gray-200">
                <div class="p-6 text-center text-gray-500">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                    Chargement des offres...
                </div>
            </div>
            
            <!-- Pagination -->
            <div id="pagination-container" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button id="prev-page-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Précédent
                    </button>
                    <button id="next-page-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Suivant
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p id="pagination-info" class="text-sm text-gray-700">
                            Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">20</span> offres
                        </p>
                    </div>
                    <div>
                        <nav id="pagination-nav" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button id="prev-page" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <!-- Page numbers will be inserted here -->
                            <div id="page-numbers" class="bg-white border-gray-300">
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                            </div>
                            <button id="next-page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="sr-only">Suivant</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bulk Actions -->
    <div id="bulk-actions" class="fixed bottom-0 left-0 right-0 bg-white shadow-md py-4 px-4 md:px-6 hidden">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center mb-3 sm:mb-0">
                <span id="selected-count" class="text-sm font-medium text-gray-900">0 offres sélectionnées</span>
                <button id="clear-selection" class="ml-3 text-xs text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times mr-1"></i>
                    Effacer la sélection
                </button>
            </div>
            <div class="flex space-x-3">
                <button id="bulk-activate" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-check-circle mr-2"></i>
                    Activer
                </button>
                <button id="bulk-deactivate" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <i class="fas fa-pause-circle mr-2"></i>
                    Suspendre
                </button>
                <button id="bulk-archive" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-archive mr-2"></i>
                    Archiver
                </button>
                <button id="bulk-delete" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Job Actions Modal -->
<div id="job-actions-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div id="modal-icon" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i id="modal-icon-class" class="fas fa-cog text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Actions sur l'offre
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="modal-description">
                                Que souhaitez-vous faire avec cette offre d'emploi ?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="modal-confirm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer
                </button>
                <button type="button" id="modal-cancel" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Job Management State
        const state = {
            jobs: [],
            filteredJobs: [],
            currentPage: 1,
            itemsPerPage: 10,
            filters: {
                status: 'all',
                date: 'all',
                applications: 'all',
                search: ''
            },
            sort: 'newest',
            selectedJobs: new Set()
        };
        
        // DOM Elements
        const elements = {
            statusFilter: document.getElementById('status-filter'),
            dateFilter: document.getElementById('date-filter'),
            applicationsFilter: document.getElementById('applications-filter'),
            searchInput: document.getElementById('search-jobs'),
            applyFiltersBtn: document.getElementById('apply-filters'),
            sortSelect: document.getElementById('sort-jobs'),
            jobsContainer: document.getElementById('jobs-container'),
            jobsCount: document.getElementById('jobs-count'),
            paginationInfo: document.getElementById('pagination-info'),
            pageNumbers: document.getElementById('page-numbers'),
            prevPageBtn: document.getElementById('prev-page'),
            nextPageBtn: document.getElementById('next-page'),
            prevPageMobileBtn: document.getElementById('prev-page-mobile'),
            nextPageMobileBtn: document.getElementById('next-page-mobile'),
            bulkActions: document.getElementById('bulk-actions'),
            selectedCount: document.getElementById('selected-count'),
            clearSelectionBtn: document.getElementById('clear-selection'),
            bulkActivateBtn: document.getElementById('bulk-activate'),
            bulkDeactivateBtn: document.getElementById('bulk-deactivate'),
            bulkArchiveBtn: document.getElementById('bulk-archive'),
            bulkDeleteBtn: document.getElementById('bulk-delete'),
            actionsModal: document.getElementById('job-actions-modal'),
            modalTitle: document.getElementById('modal-title'),
            modalDescription: document.getElementById('modal-description'),
            modalIcon: document.getElementById('modal-icon'),
            modalIconClass: document.getElementById('modal-icon-class'),
            modalConfirmBtn: document.getElementById('modal-confirm'),
            modalCancelBtn: document.getElementById('modal-cancel')
        };
        
        // Modal config for different actions
        const modalConfigs = {
            activate: {
                title: 'Activer l\'offre',
                description: 'Êtes-vous sûr de vouloir activer cette offre d\'emploi ? Elle sera visible par les candidats.',
                iconClass: 'fa-check-circle',
                iconColor: 'green',
                confirmText: 'Activer',
                confirmColor: 'green'
            },
            deactivate: {
                title: 'Désactiver l\'offre',
                description: 'Êtes-vous sûr de vouloir désactiver cette offre d\'emploi ? Elle ne sera plus visible par les candidats.',
                iconClass: 'fa-pause-circle',
                iconColor: 'yellow',
                confirmText: 'Désactiver',
                confirmColor: 'yellow'
            },
            archive: {
                title: 'Archiver l\'offre',
                description: 'Êtes-vous sûr de vouloir archiver cette offre d\'emploi ? Elle sera conservée mais ne sera plus visible.',
                iconClass: 'fa-archive',
                iconColor: 'gray',
                confirmText: 'Archiver',
                confirmColor: 'gray'
            },
            delete: {
                title: 'Supprimer l\'offre',
                description: 'Êtes-vous sûr de vouloir supprimer cette offre d\'emploi ? Cette action est irréversible.',
                iconClass: 'fa-trash-alt',
                iconColor: 'red',
                confirmText: 'Supprimer',
                confirmColor: 'red'
            }
        };
        
        // Initialize
        try {
            // Check if API client is available
            if (!window.apiClient || !window.annonces) {
                console.error('API client not available');
                loadSampleData();
            } else {
                await loadJobs();
            }
            
            // Setup event listeners
            setupEventListeners();
            
        } catch (error) {
            console.error('Error initializing job management:', error);
            loadSampleData();
            window.showNotification('Erreur lors du chargement des offres', 'error');
        }
        
        // Load jobs from API
        async function loadJobs() {
            try {
                // In a real app, we'd call a specific endpoint for the current recruiter's jobs
                const jobs = await window.annonces.getAll();
                
                // Update state
                state.jobs = jobs;
                applyFiltersAndSort();
            } catch (error) {
                console.error('Error loading jobs:', error);
                loadSampleData();
                throw error;
            }
        }
        
        // Apply filters and sorting
        function applyFiltersAndSort() {
            // Apply filters
            state.filteredJobs = state.jobs.filter(job => {
                // Status filter
                if (state.filters.status !== 'all' && job.statut !== state.filters.status) {
                    return false;
                }
                
                // Date filter
                if (state.filters.date !== 'all') {
                    const now = new Date();
                    const jobDate = new Date(job.created_at);
                    
                    switch (state.filters.date) {
                        case 'today':
                            if (jobDate.getDate() !== now.getDate() || 
                                jobDate.getMonth() !== now.getMonth() || 
                                jobDate.getFullYear() !== now.getFullYear()) {
                                return false;
                            }
                            break;
                        case 'week':
                            const oneWeekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                            if (jobDate < oneWeekAgo) {
                                return false;
                            }
                            break;
                        case 'month':
                            if (jobDate.getMonth() !== now.getMonth() || 
                                jobDate.getFullYear() !== now.getFullYear()) {
                                return false;
                            }
                            break;
                        case 'quarter':
                            const currentQuarter = Math.floor(now.getMonth() / 3);
                            const jobQuarter = Math.floor(jobDate.getMonth() / 3);
                            if (jobQuarter !== currentQuarter || 
                                jobDate.getFullYear() !== now.getFullYear()) {
                                return false;
                            }
                            break;
                    }
                }
                
                // Applications filter
                if (state.filters.applications !== 'all') {
                    const hasApplications = job.applications_count > 0 || 
                                          (job.applications && job.applications.length > 0);
                    
                    if (state.filters.applications === 'with' && !hasApplications) {
                        return false;
                    }
                    
                    if (state.filters.applications === 'without' && hasApplications) {
                        return false;
                    }
                }
                
                // Search filter
                if (state.filters.search) {
                    const searchTerm = state.filters.search.toLowerCase();
                    const titleMatch = job.titre.toLowerCase().includes(searchTerm);
                    const descriptionMatch = job.description && job.description.toLowerCase().includes(searchTerm);
                    
                    if (!titleMatch && !descriptionMatch) {
                        return false;
                    }
                }
                
                return true;
            });
            
            // Apply sorting
            state.filteredJobs.sort((a, b) => {
                switch (state.sort) {
                    case 'newest':
                        return new Date(b.created_at) - new Date(a.created_at);
                    case 'oldest':
                        return new Date(a.created_at) - new Date(b.created_at);
                    case 'applications':
                        const aCount = a.applications_count || (a.applications ? a.applications.length : 0);
                        const bCount = b.applications_count || (b.applications ? b.applications.length : 0);
                        return bCount - aCount;
                    case 'title':
                        return a.titre.localeCompare(b.titre);
                    default:
                        return 0;
                }
            });
            
            // Reset pagination
            state.currentPage = 1;
            
            // Update UI
            updateJobsUI();
            updatePagination();
        }
        
        // Update the jobs display
        function updateJobsUI() {
            // Calculate pagination
            const startIndex = (state.currentPage - 1) * state.itemsPerPage;
            const endIndex = startIndex + state.itemsPerPage;
            const paginatedJobs = state.filteredJobs.slice(startIndex, endIndex);
            
            // Update count
            elements.jobsCount.textContent = `${state.filteredJobs.length} offre${state.filteredJobs.length !== 1 ? 's' : ''}`;
            
            // Clear container
            elements.jobsContainer.innerHTML = '';
            
            // If no jobs, show message
            if (paginatedJobs.length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'p-6 text-center text-gray-500';
                emptyState.innerHTML = `
                    <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune offre trouvée</h3>
                    <p class="mt-1 text-sm text-gray-500">Aucune offre ne correspond à vos critères de recherche.</p>
                    <button id="reset-filters" class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-redo mr-2"></i>
                        Réinitialiser les filtres
                    </button>
                `;
                elements.jobsContainer.appendChild(emptyState);
                
                // Add event listener
                document.getElementById('reset-filters').addEventListener('click', resetFilters);
                return;
            }
            
            // Render each job
            paginatedJobs.forEach(job => {
                // Calculate applications count
                const applicationsCount = job.applications_count || 
                    (job.applications ? job.applications.length : 0);
                
                // Format date
                const jobDate = new Date(job.created_at);
                const formattedDate = jobDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                
                // Status badge
                let statusBadge = '';
                switch(job.statut) {
                    case 'ouverte':
                        statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>';
                        break;
                    case 'fermee':
                        statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Fermée</span>';
                        break;
                    case 'archivee':
                        statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Archivée</span>';
                        break;
                    case 'brouillon':
                        statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Brouillon</span>';
                        break;
                    default:
                        statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inconnu</span>';
                }
                
                // Job tags
                let tagsHtml = '';
                if (job.tags && job.tags.length > 0) {
                    const tagsToShow = job.tags.slice(0, 3);
                    tagsHtml = tagsToShow.map(tag => 
                        `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                            ${tag.nom}
                        </span>`
                    ).join('');
                    
                    if (job.tags.length > 3) {
                        tagsHtml += `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            +${job.tags.length - 3}
                        </span>`;
                    }
                }
                
                // Create job card element
                const jobCard = document.createElement('div');
                jobCard.className = 'p-6 hover:bg-gray-50 transition-colors duration-200';
                jobCard.dataset.jobId = job.id;
                
                jobCard.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-1">
                            <input type="checkbox" class="job-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                data-job-id="${job.id}" ${state.selectedJobs.has(job.id.toString()) ? 'checked' : ''}>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">
                                        <a href="/recruteur/jobs/${job.id}" class="hover:text-blue-600">${job.titre}</a>
                                    </h4>
                                    <div class="mt-1 flex flex-wrap items-center text-sm text-gray-500">
                                        <span>Publiée le ${formattedDate}</span>
                                        <span class="mx-2">•</span>
                                        ${statusBadge}
                                        <span class="mx-2">•</span>
                                        <span>${applicationsCount} candidature${applicationsCount !== 1 ? 's' : ''}</span>
                                    </div>
                                </div>
                                <div class="mt-3 md:mt-0 flex items-center">
                                    <div class="flex-shrink-0 flex md:ml-4">
                                        <div class="relative inline-block text-left dropdown">
                                            <button type="button" class="job-actions-btn inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-job-id="${job.id}">
                                                Actions
                                                <i class="fas fa-chevron-down ml-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${tagsHtml ? `<div class="mt-2">
                                ${tagsHtml}
                            </div>` : ''}
                        </div>
                    </div>
                `;
                
                elements.jobsContainer.appendChild(jobCard);
            });
            
            // Add event listeners to job cards
            addJobCardEventListeners();
        }
        
        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(state.filteredJobs.length / state.itemsPerPage);
            const startItem = ((state.currentPage - 1) * state.itemsPerPage) + 1;
            const endItem = Math.min(startItem + state.itemsPerPage - 1, state.filteredJobs.length);
            
            // Update pagination info
            elements.paginationInfo.innerHTML = state.filteredJobs.length > 0 
                ? `Affichage de <span class="font-medium">${startItem}</span> à <span class="font-medium">${endItem}</span> sur <span class="font-medium">${state.filteredJobs.length}</span> offres`
                : 'Aucune offre à afficher';
            
            // Disable/Enable pagination buttons
            elements.prevPageBtn.disabled = state.currentPage <= 1;
            elements.nextPageBtn.disabled = state.currentPage >= totalPages;
            elements.prevPageMobileBtn.disabled = state.currentPage <= 1;
            elements.nextPageMobileBtn.disabled = state.currentPage >= totalPages;
            
            // Toggle pagination container visibility
            if (totalPages <= 1) {
                elements.pageNumbers.classList.add('hidden');
            } else {
                elements.pageNumbers.classList.remove('hidden');
            }
            
            // Create page numbers
            elements.pageNumbers.innerHTML = '';
            
            // Logic for showing page numbers (current page, 2 before, 2 after, first, last)
            const maxPagesToShow = 5;
            let startPage = Math.max(1, state.currentPage - 2);
            let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
            
            if (endPage - startPage + 1 < maxPagesToShow) {
                startPage = Math.max(1, endPage - maxPagesToShow + 1);
            }
            
            // First page
            if (startPage > 1) {
                const firstPageBtn = createPageButton(1, state.currentPage === 1);
                elements.pageNumbers.appendChild(firstPageBtn);
                
                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                    ellipsis.textContent = '...';
                    elements.pageNumbers.appendChild(ellipsis);
                }
            }
            
            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = createPageButton(i, state.currentPage === i);
                elements.pageNumbers.appendChild(pageBtn);
            }
            
            // Last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                    ellipsis.textContent = '...';
                    elements.pageNumbers.appendChild(ellipsis);
                }
                
                const lastPageBtn = createPageButton(totalPages, state.currentPage === totalPages);
                elements.pageNumbers.appendChild(lastPageBtn);
            }
        }
        
        // Create a page button for pagination
        function createPageButton(pageNumber, isActive) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = isActive
                ? 'relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600'
                : 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50';
            button.textContent = pageNumber;
            
            if (!isActive) {
                button.addEventListener('click', () => {
                    state.currentPage = pageNumber;
                    updateJobsUI();
                    updatePagination();
                });
            }
            
            return button;
        }
        
        // Setup event listeners
        function setupEventListeners() {
            // Filter change events
            elements.statusFilter.addEventListener('change', () => {
                state.filters.status = elements.statusFilter.value;
            });
            
            elements.dateFilter.addEventListener('change', () => {
                state.filters.date = elements.dateFilter.value;
            });
            
            elements.applicationsFilter.addEventListener('change', () => {
                state.filters.applications = elements.applicationsFilter.value;
            });
            
            elements.searchInput.addEventListener('input', () => {
                state.filters.search = elements.searchInput.value;
            });
            
            // Apply filters button
            elements.applyFiltersBtn.addEventListener('click', () => {
                applyFiltersAndSort();
            });
            
            // Enter key in search
            elements.searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    applyFiltersAndSort();
                }
            });
            
            // Sort change
            elements.sortSelect.addEventListener('change', () => {
                state.sort = elements.sortSelect.value;
                applyFiltersAndSort();
            });
            
            // Pagination
            elements.prevPageBtn.addEventListener('click', () => {
                if (state.currentPage > 1) {
                    state.currentPage--;
                    updateJobsUI();
                    updatePagination();
                }
            });
            
            elements.nextPageBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(state.filteredJobs.length / state.itemsPerPage);
                if (state.currentPage < totalPages) {
                    state.currentPage++;
                    updateJobsUI();
                    updatePagination();
                }
            });
            
            elements.prevPageMobileBtn.addEventListener('click', () => {
                if (state.currentPage > 1) {
                    state.currentPage--;
                    updateJobsUI();
                    updatePagination();
                }
            });
            
            elements.nextPageMobileBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(state.filteredJobs.length / state.itemsPerPage);
                if (state.currentPage < totalPages) {
                    state.currentPage++;
                    updateJobsUI();
                    updatePagination();
                }
            });
            
            // Bulk selection
            elements.clearSelectionBtn.addEventListener('click', () => {
                state.selectedJobs.clear();
                updateSelectedCount();
                updateBulkActionsVisibility();
                // Update checkboxes
                document.querySelectorAll('.job-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
            
            // Bulk actions
            elements.bulkActivateBtn.addEventListener('click', () => {
                showModal('activate', true);
            });
            
            elements.bulkDeactivateBtn.addEventListener('click', () => {
                showModal('deactivate', true);
            });
            
            elements.bulkArchiveBtn.addEventListener('click', () => {
                showModal('archive', true);
            });
            
            elements.bulkDeleteBtn.addEventListener('click', () => {
                showModal('delete', true);
            });
            
            // Modal
            elements.modalCancelBtn.addEventListener('click', hideModal);
            elements.modalConfirmBtn.addEventListener('click', handleModalConfirm);
            
            // Close modal when clicking outside
            elements.actionsModal.addEventListener('click', (e) => {
                if (e.target === elements.actionsModal) {
                    hideModal();
                }
            });
            
            // Escape key to close modal
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !elements.actionsModal.classList.contains('hidden')) {
                    hideModal();
                }
            });
        }
        
        // Add event listeners to job cards (needs to be called after rendering)
        function addJobCardEventListeners() {
            // Job checkboxes
            document.querySelectorAll('.job-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const jobId = checkbox.dataset.jobId;
                    
                    if (checkbox.checked) {
                        state.selectedJobs.add(jobId);
                    } else {
                        state.selectedJobs.delete(jobId);
                    }
                    
                    updateSelectedCount();
                    updateBulkActionsVisibility();
                });
            });
            
            // Job action buttons
            document.querySelectorAll('.job-actions-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const jobId = button.dataset.jobId;
                    const job = state.jobs.find(j => j.id.toString() === jobId);
                    
                    // Show context menu (Using modal for simplicity - in production you might use a dropdown)
                    showJobActionMenu(job);
                });
            });
        }
        
        // Show job action menu (single job)
        function showJobActionMenu(job) {
            const actionsList = document.createElement('div');
            actionsList.className = 'py-1';
            
            // Available actions based on job status
            const actions = [];
            
            if (job.statut === 'ouverte') {
                actions.push({
                    label: 'Voir les candidats',
                    icon: 'fa-users',
                    action: () => window.location.href = `/recruteur/candidates?job=${job.id}`
                });
                actions.push({
                    label: 'Modifier',
                    icon: 'fa-edit',
                    action: () => window.location.href = `/recruteur/jobs/${job.id}/edit`
                });
                actions.push({
                    label: 'Désactiver',
                    icon: 'fa-pause-circle',
                    action: () => showModal('deactivate', false, job)
                });
                actions.push({
                    label: 'Archiver',
                    icon: 'fa-archive',
                    action: () => showModal('archive', false, job)
                });
            } else if (job.statut === 'fermee') {
                actions.push({
                    label: 'Voir les candidats',
                    icon: 'fa-users',
                    action: () => window.location.href = `/recruteur/candidates?job=${job.id}`
                });
                actions.push({
                    label: 'Modifier',
                    icon: 'fa-edit',
                    action: () => window.location.href = `/recruteur/jobs/${job.id}/edit`
                });
                actions.push({
                    label: 'Activer',
                    icon: 'fa-check-circle',
                    action: () => showModal('activate', false, job)
                });
                actions.push({
                    label: 'Archiver',
                    icon: 'fa-archive',
                    action: () => showModal('archive', false, job)
                });
            } else if (job.statut === 'archivee') {
                actions.push({
                    label: 'Voir les candidats',
                    icon: 'fa-users',
                    action: () => window.location.href = `/recruteur/candidates?job=${job.id}`
                });
                actions.push({
                    label: 'Restaurer',
                    icon: 'fa-undo',
                    action: () => showModal('activate', false, job)
                });
            } else if (job.statut === 'brouillon') {
                actions.push({
                    label: 'Modifier',
                    icon: 'fa-edit',
                    action: () => window.location.href = `/recruteur/jobs/${job.id}/edit`
                });
                actions.push({
                    label: 'Publier',
                    icon: 'fa-check-circle',
                    action: () => showModal('activate', false, job)
                });
            }
            
            // Always add delete option
            actions.push({
                label: 'Supprimer',
                icon: 'fa-trash-alt',
                action: () => showModal('delete', false, job)
            });
            
            // Create modal content
            elements.modalTitle.textContent = `Actions pour "${job.titre}"`;
            elements.modalDescription.textContent = 'Choisissez une action à effectuer sur cette offre d\'emploi.';
            elements.modalIcon.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10';
            elements.modalIconClass.className = 'fas fa-cog text-blue-600';
            
            // Create action buttons
            elements.modalConfirmBtn.style.display = 'none'; // Hide default confirm button
            
            // Clear previous content
            const modalBody = elements.modalDescription.parentElement;
            const oldActionButtons = modalBody.querySelector('.action-buttons');
            if (oldActionButtons) {
                modalBody.removeChild(oldActionButtons);
            }
            
            // Create action buttons container
            const actionButtons = document.createElement('div');
            actionButtons.className = 'action-buttons mt-4 grid grid-cols-1 gap-2';
            
            // Add action buttons
            actions.forEach(action => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'inline-flex justify-center items-center w-full px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500';
                button.innerHTML = `<i class="fas ${action.icon} mr-2"></i> ${action.label}`;
                button.addEventListener('click', () => {
                    hideModal();
                    action.action();
                });
                
                actionButtons.appendChild(button);
            });
            
            modalBody.appendChild(actionButtons);
            
            // Show modal
            elements.actionsModal.classList.remove('hidden');
        }
        
        // Show modal for job actions (single or bulk)
        function showModal(action, isBulk, job = null) {
            // Get modal config
            const config = modalConfigs[action];
            
            // Apply configuration
            elements.modalTitle.textContent = config.title + (isBulk ? ' (sélection)' : '');
            elements.modalDescription.textContent = config.description;
            elements.modalIcon.className = `mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-${config.iconColor}-100 sm:mx-0 sm:h-10 sm:w-10`;
            elements.modalIconClass.className = `fas ${config.iconClass} text-${config.iconColor}-600`;
            elements.modalConfirmBtn.textContent = config.confirmText;
            elements.modalConfirmBtn.className = `w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-${config.confirmColor}-600 text-base font-medium text-white hover:bg-${config.confirmColor}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-${config.confirmColor}-500 sm:ml-3 sm:w-auto sm:text-sm`;
            
            // Restore default confirm button if hidden
            elements.modalConfirmBtn.style.display = '';
            
            // Clear any previous action buttons
            const modalBody = elements.modalDescription.parentElement;
            const oldActionButtons = modalBody.querySelector('.action-buttons');
            if (oldActionButtons) {
                modalBody.removeChild(oldActionButtons);
            }
            
            // Set modal data attributes
            elements.actionsModal.dataset.action = action;
            elements.actionsModal.dataset.isBulk = isBulk;
            if (job) {
                elements.actionsModal.dataset.jobId = job.id;
            } else {
                delete elements.actionsModal.dataset.jobId;
            }
            
            // Show modal
            elements.actionsModal.classList.remove('hidden');
        }
        
        // Hide modal
        function hideModal() {
            elements.actionsModal.classList.add('hidden');
        }
        
        // Handle modal confirm button click
        async function handleModalConfirm() {
            const action = elements.actionsModal.dataset.action;
            const isBulk = elements.actionsModal.dataset.isBulk === 'true';
            const jobId = elements.actionsModal.dataset.jobId;
            
            // Hide modal immediately
            hideModal();
            
            // Show loading notification
            window.showNotification('Traitement en cours...', 'info');
            
            try {
                if (isBulk) {
                    // Get selected job IDs
                    const selectedIds = Array.from(state.selectedJobs);
                    
                    if (selectedIds.length === 0) {
                        window.showNotification('Aucune offre sélectionnée', 'error');
                        return;
                    }
                    
                    // Process bulk action
                    await processAction(action, selectedIds);
                    
                    // Clear selection
                    state.selectedJobs.clear();
                    updateSelectedCount();
                    updateBulkActionsVisibility();
                    
                } else {
                    // Process single action
                    await processAction(action, [jobId]);
                }
                
                // Reload jobs
                await loadJobs();
                
                // Show success notification
                window.showNotification('Action effectuée avec succès', 'success');
                
            } catch (error) {
                console.error('Error processing action:', error);
                window.showNotification('Erreur lors du traitement de l\'action', 'error');
            }
        }
        
        // Process job action
        async function processAction(action, jobIds) {
            // In a real app, we'd call API endpoints to perform these actions
            // For now, we'll simulate them by updating the local state
            
            if (!window.apiClient || !window.annonces) {
                // Simulate API call for demo
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Update local jobs
                jobIds.forEach(id => {
                    const index = state.jobs.findIndex(job => job.id.toString() === id.toString());
                    if (index !== -1) {
                        switch (action) {
                            case 'activate':
                                state.jobs[index].statut = 'ouverte';
                                break;
                            case 'deactivate':
                                state.jobs[index].statut = 'fermee';
                                break;
                            case 'archive':
                                state.jobs[index].statut = 'archivee';
                                break;
                            case 'delete':
                                state.jobs.splice(index, 1);
                                break;
                        }
                    }
                });
                
                return;
            }
            
            // Process with actual API calls
            const newStatus = {
                activate: 'ouverte',
                deactivate: 'fermee',
                archive: 'archivee'
            }[action];
            
            // Process each job
            for (const id of jobIds) {
                if (action === 'delete') {
                    await window.annonces.delete(id);
                } else if (newStatus) {
                    await window.annonces.update(id, { statut: newStatus });
                }
            }
        }
        
        // Reset filters
        function resetFilters() {
            // Reset filter values
            elements.statusFilter.value = 'all';
            elements.dateFilter.value = 'all';
            elements.applicationsFilter.value = 'all';
            elements.searchInput.value = '';
            
            // Update state
            state.filters = {
                status: 'all',
                date: 'all',
                applications: 'all',
                search: ''
            };
            
            // Apply filters
            applyFiltersAndSort();
        }
        
        // Update selected count
        function updateSelectedCount() {
            elements.selectedCount.textContent = `${state.selectedJobs.size} offre${state.selectedJobs.size !== 1 ? 's' : ''} sélectionnée${state.selectedJobs.size !== 1 ? 's' : ''}`;
        }
        
        // Update bulk actions visibility
        function updateBulkActionsVisibility() {
            if (state.selectedJobs.size > 0) {
                elements.bulkActions.classList.remove('hidden');
            } else {
                elements.bulkActions.classList.add('hidden');
            }
        }
        
        // Load sample data for demo
        function loadSampleData() {
            // Generate sample jobs
            const statuses = ['ouverte', 'fermee', 'archivee', 'brouillon'];
            const titles = [
                'Développeur Full Stack',
                'UX Designer',
                'Chef de Projet Digital',
                'Data Analyst',
                'DevOps Engineer',
                'Product Owner',
                'Responsable Marketing Digital',
                'Business Developer',
                'Graphiste',
                'Administrateur Système',
                'Consultant SEO',
                'Développeur Mobile',
                'Community Manager',
                'Ingénieur QA',
                'Responsable Commercial'
            ];
            
            const tags = [
                { nom: 'JavaScript' },
                { nom: 'React' },
                { nom: 'Vue.js' },
                { nom: 'PHP' },
                { nom: 'Laravel' },
                { nom: 'UI/UX' },
                { nom: 'Figma' },
                { nom: 'Adobe XD' },
                { nom: 'Gestion de projet' },
                { nom: 'Agile' },
                { nom: 'Scrum' },
                { nom: 'Data Analysis' },
                { nom: 'Python' },
                { nom: 'AWS' },
                { nom: 'DevOps' },
                { nom: 'Docker' },
                { nom: 'Jenkins' },
                { nom: 'Marketing' },
                { nom: 'SEO' },
                { nom: 'SEM' },
                { nom: 'Business Development' },
                { nom: 'Sales' },
                { nom: 'Design' },
                { nom: 'Photoshop' },
                { nom: 'Illustrator' }
            ];
            
            // Generate 15 sample jobs
            const jobs = [];
            for (let i = 1; i <= 15; i++) {
                const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
                const randomTitle = titles[Math.floor(Math.random() * titles.length)];
                
                // Random date in the last 3 months
                const randomDate = new Date();
                randomDate.setDate(randomDate.getDate() - Math.floor(Math.random() * 90));
                
                // Random applications count (0-20)
                const applicationsCount = Math.floor(Math.random() * 21);
                
                // Random tags (1-5)
                const randomTags = [];
                const tagCount = Math.floor(Math.random() * 5) + 1;
                const availableTags = [...tags]; // Clone tags array
                
                for (let j = 0; j < tagCount; j++) {
                    if (availableTags.length === 0) break;
                    
                    const randomIndex = Math.floor(Math.random() * availableTags.length);
                    randomTags.push(availableTags[randomIndex]);
                    availableTags.splice(randomIndex, 1); // Remove used tag
                }
                
                jobs.push({
                    id: i,
                    titre: randomTitle,
                    description: 'Description du poste...',
                    statut: randomStatus,
                    created_at: randomDate.toISOString(),
                    applications_count: applicationsCount,
                    tags: randomTags
                });
            }
            
            // Update state
            state.jobs = jobs;
            
            // Apply filters and update UI
            applyFiltersAndSort();
        }
    });
</script>
@endsection