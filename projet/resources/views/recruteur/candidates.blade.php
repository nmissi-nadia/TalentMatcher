@extends('layouts.nav')

@section('title', 'Gestion des Candidatures - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des candidatures</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Filters and Search -->
    <div class="px-4 sm:px-0 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                    <div class="col-span-1 sm:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Rechercher</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Nom, email...">
                        </div>
                    </div>
                    <div>
                        <label for="offre-filter" class="block text-sm font-medium text-gray-700">Offre d'emploi</label>
                        <select id="offre-filter" name="offre-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Toutes les offres</option>
                            <!-- offre options will be added by JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select id="status-filter" name="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Tous les statuts</option>
                            <option value="en_attente">En attente</option>
                            <option value="entretien">Entretien</option>
                            <option value="test_technique">Test technique</option>
                            <option value="acceptee">Acceptée</option>
                            <option value="rejetee">Rejetée</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700">Période</label>
                        <select id="date-filter" name="date-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois-ci</option>
                            <option value="custom">Période personnalisée</option>
                        </select>
                    </div>
                    <div id="date-range-container" class="hidden sm:grid sm:grid-cols-2 sm:gap-3">
                        <div>
                            <label for="date-start" class="block text-sm font-medium text-gray-700">Date de début</label>
                            <input type="date" name="date-start" id="date-start" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="date-end" class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input type="date" name="date-end" id="date-end" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button id="apply-filters" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Appliquer les filtres
                        </button>
                        <button id="reset-filters" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="px-4 sm:px-0">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                    <tbody id="candidates-container" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                                Chargement des candidatures...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
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
                        <p class="text-sm text-gray-700" id="pagination-info">
                            Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">--</span> résultats
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="pagination-container">
                            <!-- Pagination will be inserted here by JavaScript -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Empty State for No Applications -->
    <div id="empty-state" class="px-4 py-12 sm:px-0 hidden">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune candidature</h3>
            <p class="mt-1 text-sm text-gray-500">Vous n'avez reçu aucune candidature pour le moment.</p>
            <div class="mt-6">
                <a href="{{ url('/recruteur/offres') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux offres
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div id="status-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exchange-alt text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Changer le statut de la candidature
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="candidate-name">
                                Candidature de [Nom du candidat]
                            </p>
                            <div class="mt-4">
                                <label for="new-status" class="block text-sm font-medium text-gray-700">
                                    Nouveau statut
                                </label>
                                <select id="new-status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="en_attente">En attente</option>
                                    <option value="entretien">Entretien</option>
                                    <option value="test_technique">Test technique</option>
                                    <option value="acceptee">Acceptée</option>
                                    <option value="rejetee">Rejetée</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="status-note" class="block text-sm font-medium text-gray-700">
                                    Note (optionnelle)
                                </label>
                                <textarea id="status-note" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ajouter une note concernant ce changement de statut..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm-status-change" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer
                </button>
                <button type="button" id="cancel-status-change" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
        try {
            // Initialize variables
            let applicationsData = [];
            let offresData = [];
            let currentPage = 1;
            let itemsPerPage = 10;
            let totalApplications = 0;
            let currentApplicationId = null;
            
            // Initialize filters
            const searchInput = document.getElementById('search');
            const offreFilter = document.getElementById('offre-filter');
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const dateStartInput = document.getElementById('date-start');
            const dateEndInput = document.getElementById('date-end');
            const dateRangeContainer = document.getElementById('date-range-container');
            
            // Set up event listeners
            document.getElementById('apply-filters').addEventListener('click', applyFilters);
            document.getElementById('reset-filters').addEventListener('click', resetFilters);
            document.getElementById('cancel-status-change').addEventListener('click', hideStatusModal);
            document.getElementById('modal-backdrop').addEventListener('click', hideStatusModal);
            document.getElementById('confirm-status-change').addEventListener('click', confirmStatusChange);
            
            // Handle date filter change
            dateFilter.addEventListener('change', function() {
                if (this.value === 'custom') {
                    dateRangeContainer.classList.remove('hidden');
                } else {
                    dateRangeContainer.classList.add('hidden');
                }
            });
            
            // Handle pagination events
            document.getElementById('prev-page-mobile').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderApplications();
                }
            });
            
            document.getElementById('next-page-mobile').addEventListener('click', () => {
                const totalPages = Math.ceil(totalApplications / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderApplications();
                }
            });
            
            // Load data
            await loadData();
            
            // Function to load applications and offres data
            async function loadData() {
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.candidatures || !window.annonces) {
                        console.error('API client not available');
                        showFallbackData();
                        return;
                    }
                    
                    // Get current user
                    const user = await window.auth.getCurrentUser();
                    if (!user) {
                        window.location.href = '/login';
                        return;
                    }
                    
                    // Load offres and applications in parallel
                    const [offres, applications] = await Promise.all([
                        window.annonces.getAll(),
                        window.candidatures.getAll()
                    ]);
                    
                    offresData = offres;
                    applicationsData = applications;
                    totalApplications = applications.length;
                    
                    // Populate offre filter options
                    populateoffreFilter();
                    
                    // Render applications with pagination
                    renderApplications();
                } catch (error) {
                    console.error('Error loading data:', error);
                    showFallbackData();
                    window.showNotification('Erreur lors du chargement des données', 'error');
                }
            }
            
            // Function to populate offre filter dropdown
            function populateoffreFilter() {
                // Clear existing options except "All offres"
                const alloffresOption = offreFilter.querySelector('option[value="all"]');
                offreFilter.innerHTML = '';
                offreFilter.appendChild(alloffresOption);
                
                // Add offre options
                offresData.forEach(offre => {
                    const option = document.createElement('option');
                    option.value = offre.id;
                    option.textContent = offre.titre;
                    offreFilter.appendChild(option);
                });
            }
            
            // Function to apply filters
            function applyFilters() {
                currentPage = 1; // Reset to first page on filter change
                renderApplications();
            }
            
            // Function to reset filters
            function resetFilters() {
                searchInput.value = '';
                offreFilter.value = 'all';
                statusFilter.value = 'all';
                dateFilter.value = 'all';
                dateStartInput.value = '';
                dateEndInput.value = '';
                dateRangeContainer.classList.add('hidden');
                currentPage = 1;
                renderApplications();
            }
            
            // Function to filter applications
            function getFilteredApplications() {
                // Apply search filter
                let filtered = applicationsData;
                const searchTerm = searchInput.value.toLowerCase().trim();
                if (searchTerm) {
                    filtered = filtered.filter(app => {
                        if (!app.candidat) return false;
                        
                        return app.candidat.name?.toLowerCase().includes(searchTerm) || 
                               app.candidat.email?.toLowerCase().includes(searchTerm);
                    });
                }
                
                // Apply offre filter
                const offreId = offreFilter.value;
                if (offreId !== 'all') {
                    filtered = filtered.filter(app => app.annonce_id == offreId);
                }
                
                // Apply status filter
                const status = statusFilter.value;
                if (status !== 'all') {
                    filtered = filtered.filter(app => app.statut === status);
                }
                
                // Apply date filter
                const dateValue = dateFilter.value;
                if (dateValue !== 'all') {
                    const now = new Date();
                    let startDate = null;
                    
                    switch(dateValue) {
                        case 'today':
                            startDate = new Date(now.setHours(0, 0, 0, 0));
                            break;
                        case 'week':
                            // Start of current week (Sunday)
                            const dayOfWeek = now.getDay();
                            const diff = now.getDate() - dayOfWeek;
                            startDate = new Date(now.setDate(diff));
                            startDate.setHours(0, 0, 0, 0);
                            break;
                        case 'month':
                            // Start of current month
                            startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                            break;
                        case 'custom':
                            // Custom date range
                            if (dateStartInput.value) {
                                startDate = new Date(dateStartInput.value);
                                startDate.setHours(0, 0, 0, 0);
                            }
                            
                            if (dateEndInput.value) {
                                const endDate = new Date(dateEndInput.value);
                                endDate.setHours(23, 59, 59, 999);
                                
                                filtered = filtered.filter(app => {
                                    const appDate = new Date(app.created_at);
                                    return appDate <= endDate;
                                });
                            }
                            break;
                    }
                    
                    if (startDate) {
                        filtered = filtered.filter(app => {
                            const appDate = new Date(app.created_at);
                            return appDate >= startDate;
                        });
                    }
                }
                
                // Sort by most recent first
                filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                
                return filtered;
            }
            
            // Function to render applications with pagination
            function renderApplications() {
                const filteredApplications = getFilteredApplications();
                totalApplications = filteredApplications.length;
                
                // Update empty state
                const emptyState = document.getElementById('empty-state');
                if (totalApplications === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
                
                // Calculate pagination
                const totalPages = Math.ceil(totalApplications / itemsPerPage);
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, totalApplications);
                const paginatedApplications = filteredApplications.slice(startIndex, endIndex);
                
                // Update pagination info
                const paginationInfo = document.getElementById('pagination-info');
                if (totalApplications > 0) {
                    paginationInfo.innerHTML = `
                        Affichage de <span class="font-medium">${startIndex + 1}</span> à 
                        <span class="font-medium">${endIndex}</span> sur 
                        <span class="font-medium">${totalApplications}</span> résultats
                    `;
                } else {
                    paginationInfo.innerHTML = 'Aucun résultat';
                }
                
                // Update pagination controls
                renderPagination(totalPages);
                
                // Update mobile pagination buttons
                const prevPageMobile = document.getElementById('prev-page-mobile');
                const nextPageMobile = document.getElementById('next-page-mobile');
                prevPageMobile.disabled = currentPage === 1;
                nextPageMobile.disabled = currentPage === totalPages;
                
                // Render applications list
                const candidatesContainer = document.getElementById('candidates-container');
                candidatesContainer.innerHTML = '';
                
                if (paginatedApplications.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucune candidature ne correspond aux critères de recherche.
                        </td>
                    `;
                    candidatesContainer.appendChild(emptyRow);
                    return;
                }
                
                paginatedApplications.forEach(application => {
                    // Find offre information
                    const offre = offresData.find(j => j.id == application.annonce_id) || { titre: 'Poste inconnu' };
                    
                    // Format date
                    const applicationDate = new Date(application.created_at);
                    const formattedDate = applicationDate.toLocaleDateString('fr-FR', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    
                    // Status badge styling
                    let statusBadge = '';
                    switch(application.statut) {
                        case 'en_attente':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>';
                            break;
                        case 'entretien':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Entretien</span>';
                            break;
                        case 'test_technique':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Test technique</span>';
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
                    
                    // Create application row
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50';
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
                            <div class="text-sm text-gray-900">${offre.titre}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">${formattedDate}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${statusBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" data-app-id="${application.id}" class="change-status-btn text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-exchange-alt mr-1"></i> Statut
                            </button>
                            <a href="/recruteur/candidates/${application.id}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-eye mr-1"></i> Détails
                            </a>
                        </td>
                    `;
                    
                    candidatesContainer.appendChild(row);
                });
                
                // Add event listeners to change status buttons
                document.querySelectorAll('.change-status-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const appId = this.getAttribute('data-app-id');
                        showStatusModal(appId);
                    });
                });
            }
            
            // Function to render pagination controls
            function renderPagination(totalPages) {
                const paginationContainer = document.getElementById('pagination-container');
                paginationContainer.innerHTML = '';
                
                if (totalPages <= 1) {
                    return;
                }
                
                // Previous page button
                const prevButton = document.createElement('a');
                prevButton.href = '#';
                prevButton.className = `relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'}`;
                prevButton.innerHTML = '<span class="sr-only">Précédent</span><i class="fas fa-chevron-left"></i>';
                if (currentPage > 1) {
                    prevButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentPage--;
                        renderApplications();
                    });
                }
                paginationContainer.appendChild(prevButton);
                
                // Page numbers
                const showEllipsis = totalPages > 7;
                let startPage, endPage;
                
                if (showEllipsis) {
                    if (currentPage <= 4) {
                        startPage = 1;
                        endPage = 5;
                    } else if (currentPage >= totalPages - 3) {
                        startPage = totalPages - 4;
                        endPage = totalPages;
                    } else {
                        startPage = currentPage - 2;
                        endPage = currentPage + 2;
                    }
                } else {
                    startPage = 1;
                    endPage = totalPages;
                }
                
                if (showEllipsis && startPage > 1) {
                    // First page
                    addPageButton(1);
                    
                    // Ellipsis
                    if (startPage > 2) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                        ellipsis.innerHTML = '...';
                        paginationContainer.appendChild(ellipsis);
                    }
                }
                
                // Page buttons
                for (let i = startPage; i <= endPage; i++) {
                    addPageButton(i);
                }
                
                if (showEllipsis && endPage < totalPages) {
                    // Ellipsis
                    if (endPage < totalPages - 1) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                        ellipsis.innerHTML = '...';
                        paginationContainer.appendChild(ellipsis);
                    }
                    
                    // Last page
                    addPageButton(totalPages);
                }
                
                // Next page button
                const nextButton = document.createElement('a');
                nextButton.href = '#';
                nextButton.className = `relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium ${currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'}`;
                nextButton.innerHTML = '<span class="sr-only">Suivant</span><i class="fas fa-chevron-right"></i>';
                if (currentPage < totalPages) {
                    nextButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentPage++;
                        renderApplications();
                    });
                }
                paginationContainer.appendChild(nextButton);
                
                // Helper to add page button
                function addPageButton(pageNumber) {
                    const pageButton = document.createElement('a');
                    pageButton.href = '#';
                    pageButton.className = `relative inline-flex items-center px-4 py-2 border ${currentPage === pageNumber ? 'bg-blue-50 border-blue-500 z-10 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'} text-sm font-medium`;
                    pageButton.innerHTML = pageNumber;
                    
                    if (currentPage !== pageNumber) {
                        pageButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            currentPage = pageNumber;
                            renderApplications();
                        });
                    }
                    
                    paginationContainer.appendChild(pageButton);
                }
            }
            
            // Function to show the status change modal
            function showStatusModal(applicationId) {
                // Find application data
                const application = applicationsData.find(app => app.id == applicationId);
                if (!application) return;
                
                // Update modal content
                currentApplicationId = applicationId;
                document.getElementById('candidate-name').textContent = `Candidature de ${application.candidat?.name || 'Candidat'}`;
                document.getElementById('new-status').value = application.statut || 'en_attente';
                document.getElementById('status-note').value = '';
                
                // Show modal
                const modal = document.getElementById('status-modal');
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            // Function to hide the status change modal
            function hideStatusModal() {
                const modal = document.getElementById('status-modal');
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                currentApplicationId = null;
            }
            
            // Function to confirm status change
            async function confirmStatusChange() {
                if (!currentApplicationId) return;
                
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.candidatures) {
                        console.error('API client not available');
                        simulateStatusChange();
                        return;
                    }
                    
                    // Get new status and note
                    const newStatus = document.getElementById('new-status').value;
                    const note = document.getElementById('status-note').value.trim();
                    
                    // Prepare data to update
                    const updateData = {
                        statut: newStatus,
                        note: note || undefined
                    };
                    
                    // Update application status
                    await window.candidatures.update(currentApplicationId, updateData);
                    
                    // Update local data
                    const applicationIndex = applicationsData.findIndex(app => app.id == currentApplicationId);
                    if (applicationIndex !== -1) {
                        applicationsData[applicationIndex].statut = newStatus;
                        if (note) {
                            applicationsData[applicationIndex].note = note;
                        }
                    }
                    
                    // Re-render applications
                    renderApplications();
                    
                    // Show success notification
                    window.showNotification('Statut mis à jour avec succès', 'success');
                } catch (error) {
                    console.error('Error updating application status:', error);
                    window.showNotification('Erreur lors de la mise à jour du statut', 'error');
                } finally {
                    hideStatusModal();
                }
            }
            
            // Function to simulate status change for demo
            function simulateStatusChange() {
                // Get new status
                const newStatus = document.getElementById('new-status').value;
                
                // Update local data
                const applicationIndex = applicationsData.findIndex(app => app.id == currentApplicationId);
                if (applicationIndex !== -1) {
                    applicationsData[applicationIndex].statut = newStatus;
                }
                
                // Re-render applications
                renderApplications();
                
                // Show success notification
                window.showNotification('Statut mis à jour avec succès', 'success');
                
                // Hide modal
                hideStatusModal();
            }
            
            // Function to show fallback data when API fails
            function showFallbackData() {
                // Generate sample data
                offresData = generateSampleoffres();
                applicationsData = generateSampleApplications();
                totalApplications = applicationsData.length;
                
                // Populate offre filter
                populateoffreFilter();
                
                // Render applications
                renderApplications();
            }
            
            // Function to generate sample offres for demo purposes
            function generateSampleoffres() {
                return [
                    { id: 1, titre: 'Développeur Full Stack' },
                    { id: 2, titre: 'UX Designer' },
                    { id: 3, titre: 'Chef de Projet Digital' },
                    { id: 4, titre: 'Data Analyst' },
                    { id: 5, titre: 'Développeur Mobile' }
                ];
            }
            
            // Function to generate sample applications for demo purposes
            function generateSampleApplications() {
                const now = new Date();
                
                return [
                    {
                        id: 1,
                        annonce_id: 1,
                        candidat: { name: 'Jean Dupont', email: 'jean.dupont@example.com' },
                        statut: 'en_attente',
                        created_at: new Date(now.getTime() - 2 * 86400000).toISOString() // 2 days ago
                    },
                    {
                        id: 2,
                        annonce_id: 1,
                        candidat: { name: 'Marie Martin', email: 'marie.martin@example.com' },
                        statut: 'entretien',
                        created_at: new Date(now.getTime() - 5 * 86400000).toISOString() // 5 days ago
                    },
                    {
                        id: 3,
                        annonce_id: 2,
                        candidat: { name: 'Pierre Durand', email: 'pierre.durand@example.com' },
                        statut: 'test_technique',
                        created_at: new Date(now.getTime() - 7 * 86400000).toISOString() // 7 days ago
                    },
                    {
                        id: 4,
                        annonce_id: 2,
                        candidat: { name: 'Sophie Bernard', email: 'sophie.bernard@example.com' },
                        statut: 'acceptee',
                        created_at: new Date(now.getTime() - 10 * 86400000).toISOString() // 10 days ago
                    },
                    {
                        id: 5,
                        annonce_id: 3,
                        candidat: { name: 'Thomas Petit', email: 'thomas.petit@example.com' },
                        statut: 'rejetee',
                        created_at: new Date(now.getTime() - 12 * 86400000).toISOString() // 12 days ago
                    },
                    {
                        id: 6,
                        annonce_id: 3,
                        candidat: { name: 'Julie Moreau', email: 'julie.moreau@example.com' },
                        statut: 'en_attente',
                        created_at: new Date(now.getTime() - 1 * 86400000).toISOString() // 1 day ago
                    },
                    {
                        id: 7,
                        annonce_id: 4,
                        candidat: { name: 'Alexandre Girard', email: 'alexandre.girard@example.com' },
                        statut: 'entretien',
                        created_at: new Date(now.getTime() - 3 * 86400000).toISOString() // 3 days ago
                    },
                    {
                        id: 8,
                        annonce_id: 5,
                        candidat: { name: 'Camille Dubois', email: 'camille.dubois@example.com' },
                        statut: 'en_attente',
                        created_at: new Date().toISOString() // Today
                    }
                ];
            }
        } catch (error) {
            console.error('An unexpected error occurred:', error);
            window.showNotification('Une erreur inattendue s\'est produite', 'error');
        }
    });
</script>
@endsection