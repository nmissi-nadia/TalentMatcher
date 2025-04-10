@extends('layouts.app')

@section('title', 'Mes Candidatures - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes candidatures</h1>
        <p class="mt-1 text-sm text-gray-500">Suivez l'état de vos candidatures et gérez-les facilement.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Loading State -->
    <div id="loading-state" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
        <p class="mt-4 text-gray-500">Chargement de vos candidatures...</p>
    </div>
    
    <!-- Error State -->
    <div id="error-state" class="bg-red-50 border-l-4 border-red-400 p-4 hidden">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    Une erreur est survenue lors du chargement de vos candidatures. Veuillez réessayer ultérieurement.
                </p>
                <button id="retry-button" class="mt-2 text-sm font-medium text-red-700 hover:text-red-600">
                    Réessayer
                </button>
            </div>
        </div>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="text-center py-12 bg-white rounded-lg shadow-sm hidden">
        <div class="rounded-full bg-blue-100 w-24 h-24 flex items-center justify-center mx-auto">
            <i class="fas fa-file-alt text-blue-600 text-4xl"></i>
        </div>
        <h3 class="mt-6 text-lg font-medium text-gray-900">Aucune candidature en cours</h3>
        <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
            Vous n'avez pas encore postulé à des offres d'emploi. Consultez nos offres disponibles pour trouver votre prochain emploi.
        </p>
        <div class="mt-6">
            <a href="{{ url('/candidat/jobs') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-search mr-2"></i>
                Découvrir les offres
            </a>
        </div>
    </div>
    
    <!-- Content State -->
    <div id="content-state" class="hidden">
        <!-- Filter and Search Section -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <div class="md:col-span-3">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-input" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher dans vos candidatures...">
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente">En attente</option>
                            <option value="entretien">Entretien</option>
                            <option value="acceptee">Acceptée</option>
                            <option value="rejetee">Rejetée</option>
                        </select>
                    </div>
                    
                    <!-- Date Filter -->
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                        <select id="date-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Toutes les dates</option>
                            <option value="7">7 derniers jours</option>
                            <option value="30">30 derniers jours</option>
                            <option value="90">3 derniers mois</option>
                        </select>
                    </div>
                    
                    <!-- Sort Filter -->
                    <div>
                        <label for="sort-filter" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select id="sort-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="date-desc">Plus récentes</option>
                            <option value="date-asc">Plus anciennes</option>
                            <option value="company-asc">Entreprise (A-Z)</option>
                            <option value="company-desc">Entreprise (Z-A)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Applications Table -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Candidatures
                        </h3>
                        <p class="mt-1 text-sm text-gray-500" id="applications-count">
                            Chargement...
                        </p>
                    </div>
                </div>
            </div>
            
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
                                Date de candidature
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mise à jour
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="applications-container" class="bg-white divide-y divide-gray-200">
                        <!-- Applications will be inserted here -->
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-12">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
                                    <p class="mt-4 text-gray-500">Chargement des candidatures...</p>
                                </div>
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
                            Affichage des résultats <span id="result-range">1 à 10</span> sur <span id="total-results">X</span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="pagination-container">
                            <button id="prev-page" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <!-- Pagination buttons will be added dynamically -->
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
</div>

<!-- Withdraw Application Modal -->
<div id="withdraw-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="withdraw-modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Retirer votre candidature
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir retirer votre candidature pour le poste de <span id="withdraw-job-title" class="font-medium">...</span> chez <span id="withdraw-company-name" class="font-medium">...</span> ?
                            </p>
                            <p class="text-sm text-gray-500 mt-2">
                                Cette action est irréversible et vous devrez postuler à nouveau si vous changez d'avis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="confirm-withdraw-button" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer
                </button>
                <button id="cancel-withdraw-button" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
        // State variables
        let applications = [];
        let filteredApplications = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        let currentWithdrawId = null;
        
        // Cache DOM elements
        const loadingState = document.getElementById('loading-state');
        const errorState = document.getElementById('error-state');
        const emptyState = document.getElementById('empty-state');
        const contentState = document.getElementById('content-state');
        const retryButton = document.getElementById('retry-button');
        const searchInput = document.getElementById('search-input');
        const statusFilter = document.getElementById('status-filter');
        const dateFilter = document.getElementById('date-filter');
        const sortFilter = document.getElementById('sort-filter');
        const applicationsContainer = document.getElementById('applications-container');
        const applicationsCount = document.getElementById('applications-count');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const prevPageMobileBtn = document.getElementById('prev-page-mobile');
        const nextPageMobileBtn = document.getElementById('next-page-mobile');
        const paginationContainer = document.getElementById('pagination-container');
        const resultRange = document.getElementById('result-range');
        const totalResults = document.getElementById('total-results');
        
        // Withdraw modal elements
        const withdrawModal = document.getElementById('withdraw-modal');
        const withdrawModalBackdrop = document.getElementById('withdraw-modal-backdrop');
        const withdrawJobTitle = document.getElementById('withdraw-job-title');
        const withdrawCompanyName = document.getElementById('withdraw-company-name');
        const confirmWithdrawBtn = document.getElementById('confirm-withdraw-button');
        const cancelWithdrawBtn = document.getElementById('cancel-withdraw-button');
        
        try {
            // Fetch applications
            await fetchApplications();
            
            // Set up event listeners
            setupEventListeners();
            
            // Apply initial filters
            applyFilters();
        } catch (error) {
            console.error('Error initializing applications page:', error);
            showError();
        }
        
        // Fetch all applications from API
        async function fetchApplications() {
            try {
                showLoading();
                
                // Use API client if available
                if (window.candidatures) {
                    applications = await window.candidatures.getAll();
                } else {
                    // Fallback to fetch API
                    const response = await fetch('/api/candidatures');
                    if (!response.ok) throw new Error('Failed to fetch applications');
                    applications = await response.json();
                }
                
                // Check if there are any applications
                if (applications.length === 0) {
                    showEmpty();
                } else {
                    // Initial filtering
                    filteredApplications = [...applications];
                    showContent();
                }
            } catch (error) {
                console.error('Error fetching applications:', error);
                
                // For demo purposes, show some sample data
                applications = generateSampleApplications();
                
                if (applications.length === 0) {
                    showEmpty();
                } else {
                    filteredApplications = [...applications];
                    showContent();
                }
            }
        }
        
        // Set up event listeners
        function setupEventListeners() {
            // Retry button
            retryButton.addEventListener('click', fetchApplications);
            
            // Search input (debounced)
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    applyFilters();
                }, 300);
            });
            
            // Filter changes
            statusFilter.addEventListener('change', function() {
                currentPage = 1;
                applyFilters();
            });
            
            dateFilter.addEventListener('change', function() {
                currentPage = 1;
                applyFilters();
            });
            
            sortFilter.addEventListener('change', function() {
                currentPage = 1;
                applyFilters();
            });
            
            // Pagination
            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderApplications();
                    updatePagination();
                }
            });
            
            nextPageBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredApplications.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderApplications();
                    updatePagination();
                }
            });
            
            // Mobile pagination
            prevPageMobileBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderApplications();
                    updatePagination();
                }
            });
            
            nextPageMobileBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredApplications.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderApplications();
                    updatePagination();
                }
            });
            
            // Withdraw modal
            cancelWithdrawBtn.addEventListener('click', hideWithdrawModal);
            withdrawModalBackdrop.addEventListener('click', hideWithdrawModal);
            
            confirmWithdrawBtn.addEventListener('click', withdrawApplication);
        }
        
        // Show loading state
        function showLoading() {
            loadingState.classList.remove('hidden');
            errorState.classList.add('hidden');
            emptyState.classList.add('hidden');
            contentState.classList.add('hidden');
        }
        
        // Show error state
        function showError() {
            loadingState.classList.add('hidden');
            errorState.classList.remove('hidden');
            emptyState.classList.add('hidden');
            contentState.classList.add('hidden');
        }
        
        // Show empty state
        function showEmpty() {
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            emptyState.classList.remove('hidden');
            contentState.classList.add('hidden');
        }
        
        // Show content state
        function showContent() {
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            emptyState.classList.add('hidden');
            contentState.classList.remove('hidden');
            
            renderApplications();
            updatePagination();
        }
        
        // Apply filters and sort
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const status = statusFilter.value;
            const dateRange = parseInt(dateFilter.value) || null;
            const sortBy = sortFilter.value;
            
            // Filter applications
            filteredApplications = applications.filter(app => {
                // Search term (job title, company)
                const jobTitle = app.annonce?.titre?.toLowerCase() || '';
                const company = app.annonce?.recruteur?.name?.toLowerCase() || '';
                
                if (searchTerm && !(jobTitle.includes(searchTerm) || company.includes(searchTerm))) {
                    return false;
                }
                
                // Status filter
                if (status && app.statut !== status) {
                    return false;
                }
                
                // Date range filter
                if (dateRange) {
                    const appDate = new Date(app.created_at);
                    const now = new Date();
                    const daysDiff = Math.floor((now - appDate) / (1000 * 60 * 60 * 24));
                    
                    if (daysDiff > dateRange) {
                        return false;
                    }
                }
                
                return true;
            });
            
            // Sort applications
            sortApplications(sortBy);
            
            // Reset to first page
            currentPage = 1;
            
            // Render results
            if (filteredApplications.length === 0) {
                // If no results after filtering, show empty message but keep filters visible
                applicationsContainer.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-12">
                                <p class="text-gray-500">Aucune candidature ne correspond à vos critères de recherche.</p>
                                <button id="reset-filters-btn" class="mt-4 text-sm text-blue-600 hover:text-blue-800">
                                    Réinitialiser les filtres
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                
                // Add event listener to reset filters button
                const resetFiltersBtn = document.getElementById('reset-filters-btn');
                if (resetFiltersBtn) {
                    resetFiltersBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        statusFilter.value = '';
                        dateFilter.value = '';
                        sortFilter.value = 'date-desc';
                        
                        applyFilters();
                    });
                }
                
                // Update count
                applicationsCount.textContent = 'Aucune candidature trouvée';
                
                // Hide pagination
                document.querySelector('.pagination').classList.add('hidden');
            } else {
                renderApplications();
                updatePagination();
            }
        }
        
        // Sort applications based on selected criteria
        function sortApplications(sortBy) {
            switch (sortBy) {
                case 'date-desc':
                    filteredApplications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
                case 'date-asc':
                    filteredApplications.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    break;
                case 'company-asc':
                    filteredApplications.sort((a, b) => {
                        const companyA = a.annonce?.recruteur?.name || '';
                        const companyB = b.annonce?.recruteur?.name || '';
                        return companyA.localeCompare(companyB);
                    });
                    break;
                case 'company-desc':
                    filteredApplications.sort((a, b) => {
                        const companyA = a.annonce?.recruteur?.name || '';
                        const companyB = b.annonce?.recruteur?.name || '';
                        return companyB.localeCompare(companyA);
                    });
                    break;
                default:
                    break;
            }
        }
        
        // Render applications with pagination
        function renderApplications() {
            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredApplications.length);
            const currentApplications = filteredApplications.slice(startIndex, endIndex);
            
            // Update display range
            resultRange.textContent = filteredApplications.length > 0 ? `${startIndex + 1} à ${endIndex}` : '0 à 0';
            totalResults.textContent = filteredApplications.length;
            
            // Update count
            applicationsCount.textContent = `${filteredApplications.length} candidature(s) trouvée(s)`;
            
            // Clear container
            applicationsContainer.innerHTML = '';
            
            // Create application rows
            currentApplications.forEach(application => {
                const row = document.createElement('tr');
                
                // Get job and company info
                const jobTitle = application.annonce?.titre || 'Poste inconnu';
                const company = application.annonce?.recruteur?.name || 'Entreprise inconnue';
                
                // Format dates
                const appliedDate = new Date(application.created_at);
                const formattedAppliedDate = appliedDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                
                const updatedDate = new Date(application.updated_at);
                const formattedUpdatedDate = updatedDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                
                // Status badge
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
                
                // Actions based on status
                let actionsHtml = `
                    <a href="/candidat/jobs/${application.annonce?.id}" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-eye"></i>
                    </a>
                `;
                
                // Only allow withdrawal if application is pending
                if (application.statut === 'en_attente') {
                    actionsHtml += `
                        <button data-id="${application.id}" 
                                data-job="${jobTitle}" 
                                data-company="${company}" 
                                class="text-red-600 hover:text-red-900 withdraw-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                }
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${jobTitle}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${company}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${formattedAppliedDate}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${statusBadge}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${formattedUpdatedDate}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        ${actionsHtml}
                    </td>
                `;
                
                applicationsContainer.appendChild(row);
            });
            
            // Add event listeners to withdraw buttons
            document.querySelectorAll('.withdraw-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const applicationId = this.getAttribute('data-id');
                    const jobTitle = this.getAttribute('data-job');
                    const company = this.getAttribute('data-company');
                    
                    showWithdrawModal(applicationId, jobTitle, company);
                });
            });
        }
        
        // Update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredApplications.length / itemsPerPage);
            
            // Update button states
            prevPageBtn.disabled = currentPage <= 1;
            nextPageBtn.disabled = currentPage >= totalPages;
            prevPageMobileBtn.disabled = currentPage <= 1;
            nextPageMobileBtn.disabled = currentPage >= totalPages;
            
            // Remove existing page buttons
            const pageButtons = paginationContainer.querySelectorAll('.page-button');
            pageButtons.forEach(button => button.remove());
            
            // Determine page range to show
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            // Adjust if we're near the end
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }
            
            // Insert page buttons
            for (let i = startPage; i <= endPage; i++) {
                const button = document.createElement('button');
                button.className = `page-button relative inline-flex items-center px-4 py-2 border ${
                    i === currentPage
                        ? 'border-blue-500 bg-blue-50 text-blue-600'
                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                } text-sm font-medium`;
                button.textContent = i;
                
                button.addEventListener('click', function() {
                    currentPage = i;
                    renderApplications();
                    updatePagination();
                });
                
                // Insert before next button
                paginationContainer.insertBefore(button, nextPageBtn);
            }
        }
        
        // Show withdraw modal
        function showWithdrawModal(applicationId, jobTitle, company) {
            currentWithdrawId = applicationId;
            withdrawJobTitle.textContent = jobTitle;
            withdrawCompanyName.textContent = company;
            withdrawModal.classList.remove('hidden');
        }
        
        // Hide withdraw modal
        function hideWithdrawModal() {
            withdrawModal.classList.add('hidden');
            currentWithdrawId = null;
        }
        
        // Withdraw application
        async function withdrawApplication() {
            if (!currentWithdrawId) return;
            
            // Disable button to prevent multiple submissions
            confirmWithdrawBtn.disabled = true;
            confirmWithdrawBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...';
            
            try {
                // Use API client if available
                if (window.candidatures) {
                    await window.candidatures.withdraw(currentWithdrawId);
                    
                    // Remove application from arrays
                    applications = applications.filter(app => app.id != currentWithdrawId);
                    filteredApplications = filteredApplications.filter(app => app.id != currentWithdrawId);
                    
                    // Hide modal
                    hideWithdrawModal();
                    
                    // Show success notification
                    if (window.showNotification) {
                        window.showNotification('Candidature retirée avec succès', 'success');
                    }
                    
                    // Check if we need to adjust pagination
                    if (filteredApplications.length === 0) {
                        // No more applications after filtering
                        if (applications.length === 0) {
                            // No applications at all
                            showEmpty();
                        } else {
                            // There are still applications, just none match the filter
                            renderApplications();
                            updatePagination();
                        }
                    } else {
                        // Still have applications to show
                        renderApplications();
                        updatePagination();
                    }
                } else {
                    // Fallback for demo
                    setTimeout(() => {
                        // Remove application from arrays
                        applications = applications.filter(app => app.id != currentWithdrawId);
                        filteredApplications = filteredApplications.filter(app => app.id != currentWithdrawId);
                        
                        // Hide modal
                        hideWithdrawModal();
                        
                        // Show success notification
                        if (window.showNotification) {
                            window.showNotification('Candidature retirée avec succès', 'success');
                        }
                        
                        // Check if we need to adjust pagination
                        if (filteredApplications.length === 0) {
                            // No more applications after filtering
                            if (applications.length === 0) {
                                // No applications at all
                                showEmpty();
                            } else {
                                // There are still applications, just none match the filter
                                renderApplications();
                                updatePagination();
                            }
                        } else {
                            // Still have applications to show
                            renderApplications();
                            updatePagination();
                        }
                    }, 1000);
                }
            } catch (error) {
                console.error('Error withdrawing application:', error);
                
                // Reset button
                confirmWithdrawBtn.disabled = false;
                confirmWithdrawBtn.innerHTML = 'Confirmer';
                
                // Show error notification
                if (window.showNotification) {
                    window.showNotification('Une erreur est survenue lors du retrait de la candidature', 'error');
                }
            }
        }
        
        // Generate sample applications for demo
        function generateSampleApplications() {
            const jobTitles = [
                'Développeur Full Stack',
                'UX Designer',
                'Chef de Projet Digital',
                'Développeur Mobile',
                'Data Scientist'
            ];
            
            const companies = [
                'TechCorp',
                'DesignStudio',
                'DigitalAgency',
                'MobileApps',
                'DataWorks'
            ];
            
            const statuses = [
                'en_attente',
                'entretien',
                'acceptee',
                'rejetee'
            ];
            
            // Generate 5 sample applications
            return Array.from({ length: 5 }, (_, i) => {
                const createdDate = new Date();
                createdDate.setDate(createdDate.getDate() - Math.floor(Math.random() * 30));
                
                const updatedDate = new Date(createdDate);
                updatedDate.setDate(updatedDate.getDate() + Math.floor(Math.random() * 7));
                
                const status = statuses[Math.floor(Math.random() * statuses.length)];
                
                return {
                    id: i + 1,
                    id_annonce: i + 100,
                    id_candidat: 1,
                    statut: status,
                    created_at: createdDate.toISOString(),
                    updated_at: updatedDate.toISOString(),
                    annonce: {
                        id: i + 100,
                        titre: jobTitles[i],
                        recruteur: {
                            name: companies[i]
                        }
                    }
                };
            });
        }
    });
</script>
@endsection