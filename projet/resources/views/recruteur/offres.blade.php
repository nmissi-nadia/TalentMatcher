@extends('layouts.app')

@section('title', 'Gestion des Offres - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des offres d'emploi</h1>
        <a href="{{ url('/recruteur/offres/create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i>
            Publier une offre
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Filters and Search -->
    <div class="px-4 sm:px-0 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                    <div class="col-span-1 sm:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Rechercher une offre</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Titre, description...">
                        </div>
                    </div>
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select id="status-filter" name="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="all">Tous les statuts</option>
                            <option value="ouverte">Ouvertes</option>
                            <option value="fermee">Fermées</option>
                            <option value="brouillon">Brouillons</option>
                            <option value="expiree">Expirées</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort-by" class="block text-sm font-medium text-gray-700">Trier par</label>
                        <select id="sort-by" name="sort-by" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="created_at_desc">Plus récentes</option>
                            <option value="created_at_asc">Plus anciennes</option>
                            <option value="applications_desc">Plus de candidatures</option>
                            <option value="applications_asc">Moins de candidatures</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button id="apply-filters" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Appliquer les filtres
                    </button>
                    <button id="reset-filters" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- offre Listings -->
    <div class="px-4 sm:px-0">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul id="offres-container" class="divide-y divide-gray-200">
                <li class="p-6 text-center text-gray-500">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                    Chargement des offres d'emploi...
                </li>
            </ul>
            
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
    
    <!-- Empty State for No offres -->
    <div id="empty-state" class="px-4 py-12 sm:px-0 hidden">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune offre d'emploi</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par publier votre première offre d'emploi.</p>
            <div class="mt-6">
                <a href="{{ url('/recruteur/offres/create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>
                    Publier une offre
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal for Deleting offre -->
<div id="delete-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Supprimer l'offre d'emploi
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir supprimer cette offre d'emploi ? Cette action est irréversible et supprimera également toutes les candidatures associées.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm-delete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Supprimer
                </button>
                <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
            let offresData = [];
            let currentPage = 1;
            let itemsPerPage = 10;
            let totaloffres = 0;
            let currentoffreIdToDelete = null;
            
            // Initialize filters
            const searchInput = document.getElementById('search');
            const statusFilter = document.getElementById('status-filter');
            const sortBy = document.getElementById('sort-by');
            
            // Load offres from API
            await loadoffres();
            
            // Set up event listeners
            document.getElementById('apply-filters').addEventListener('click', applyFilters);
            document.getElementById('reset-filters').addEventListener('click', resetFilters);
            document.getElementById('cancel-delete').addEventListener('click', hideDeleteModal);
            document.getElementById('modal-backdrop').addEventListener('click', hideDeleteModal);
            document.getElementById('confirm-delete').addEventListener('click', confirmDeleteoffre);
            
            // Handle pagination events
            document.getElementById('prev-page-mobile').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderoffres();
                }
            });
            
            document.getElementById('next-page-mobile').addEventListener('click', () => {
                const totalPages = Math.ceil(totaloffres / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderoffres();
                }
            });
            
            // Function to load offres from API
            async function loadoffres() {
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.annonces) {
                        console.error('API client not available');
                        showFallbackData();
                        return;
                    }
                    
                    // Get all offres for the current recruiter
                    const user = await window.auth.getCurrentUser();
                    if (!user) {
                        window.location.href = '/login';
                        return;
                    }
                    
                    offresData = await window.annonces.getAll();
                    totaloffres = offresData.length;
                    
                    // Render offres
                    renderoffres();
                } catch (error) {
                    console.error('Error loading offres:', error);
                    showFallbackData();
                    window.showNotification('Erreur lors du chargement des offres', 'error');
                }
            }
            
            // Function to apply filters
            function applyFilters() {
                currentPage = 1; // Reset to first page on filter change
                renderoffres();
            }
            
            // Function to reset filters
            function resetFilters() {
                searchInput.value = '';
                statusFilter.value = 'all';
                sortBy.value = 'created_at_desc';
                currentPage = 1;
                renderoffres();
            }
            
            // Function to filter and sort offres
            function getFilteredAndSortedoffres() {
                // Apply search filter
                let filtered = offresData;
                const searchTerm = searchInput.value.toLowerCase().trim();
                if (searchTerm) {
                    filtered = filtered.filter(offre => 
                        offre.titre.toLowerCase().includes(searchTerm) || 
                        offre.description.toLowerCase().includes(searchTerm)
                    );
                }
                
                // Apply status filter
                const status = statusFilter.value;
                if (status !== 'all') {
                    filtered = filtered.filter(offre => offre.statut === status);
                }
                
                // Apply sorting
                const sort = sortBy.value;
                switch(sort) {
                    case 'created_at_desc':
                        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                        break;
                    case 'created_at_asc':
                        filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                        break;
                    case 'applications_desc':
                        filtered.sort((a, b) => (b.applications_count || 0) - (a.applications_count || 0));
                        break;
                    case 'applications_asc':
                        filtered.sort((a, b) => (a.applications_count || 0) - (b.applications_count || 0));
                        break;
                }
                
                return filtered;
            }
            
            // Function to render offres with pagination
            function renderoffres() {
                const filteredoffres = getFilteredAndSortedoffres();
                totaloffres = filteredoffres.length;
                
                // Update empty state
                const emptyState = document.getElementById('empty-state');
                if (totaloffres === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
                
                // Calculate pagination
                const totalPages = Math.ceil(totaloffres / itemsPerPage);
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, totaloffres);
                const paginatedoffres = filteredoffres.slice(startIndex, endIndex);
                
                // Update pagination info
                const paginationInfo = document.getElementById('pagination-info');
                if (totaloffres > 0) {
                    paginationInfo.innerHTML = `
                        Affichage de <span class="font-medium">${startIndex + 1}</span> à 
                        <span class="font-medium">${endIndex}</span> sur 
                        <span class="font-medium">${totaloffres}</span> résultats
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
                
                // Render offre list
                const offresContainer = document.getElementById('offres-container');
                offresContainer.innerHTML = '';
                
                if (paginatedoffres.length === 0) {
                    const emptyLi = document.createElement('li');
                    emptyLi.className = 'p-6 text-center text-gray-500';
                    emptyLi.innerHTML = 'Aucune offre ne correspond aux critères de recherche.';
                    offresContainer.appendChild(emptyLi);
                    return;
                }
                
                paginatedoffres.forEach(offre => {
                    // Format dates
                    const createdDate = new Date(offre.created_at);
                    const formattedDate = createdDate.toLocaleDateString('fr-FR', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    
                    // Determine status badge style
                    let statusBadge = '';
                    switch(offre.statut) {
                        case 'ouverte':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>';
                            break;
                        case 'fermee':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Fermée</span>';
                            break;
                        case 'brouillon':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Brouillon</span>';
                            break;
                        case 'expiree':
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Expirée</span>';
                            break;
                        default:
                            statusBadge = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inconnu</span>';
                    }
                    
                    // Calculate applications count
                    const applicationsCount = offre.applications_count || 
                        (offre.applications ? offre.applications.length : '0');
                    
                    // Generate tags HTML if available
                    let tagsHtml = '';
                    if (offre.tags && offre.tags.length > 0) {
                        tagsHtml = `
                            <div class="mt-2 flex flex-wrap gap-2">
                                ${offre.tags.slice(0, 3).map(tag => 
                                    `<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">${tag.nom}</span>`
                                ).join('')}
                                ${offre.tags.length > 3 ? 
                                    `<span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">+${offre.tags.length - 3} plus</span>` : 
                                    ''}
                            </div>
                        `;
                    }
                    
                    // Create offre card
                    const offreItem = document.createElement('li');
                    offreItem.className = 'p-6 hover:bg-gray-50 transition-colors duration-200';
                    offreItem.innerHTML = `
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <h4 class="text-lg font-medium text-gray-900">
                                        <a href="/recruteur/offres/${offre.id}" class="hover:text-blue-600">${offre.titre}</a>
                                    </h4>
                                    <div class="ml-2">
                                        ${statusBadge}
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Publié le ${formattedDate}</p>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">${offre.description}</p>
                                ${tagsHtml}
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-col items-end">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-user-friends mr-1"></i> ${applicationsCount} candidature(s)
                                </span>
                                <div class="mt-3 flex">
                                    <a href="/recruteur/candidates?offre=${offre.id}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                                        <i class="fas fa-users mr-2"></i>
                                        Candidats
                                    </a>
                                    <a href="/recruteur/offres/${offre.id}/edit" class="ml-3 inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                                        <i class="fas fa-edit mr-2"></i>
                                        Modifier
                                    </a>
                                    <button type="button" data-offre-id="${offre.id}" class="delete-offre-btn ml-3 inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-red-300 focus:shadow-outline-red active:text-red-800 active:bg-gray-50">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    offresContainer.appendChild(offreItem);
                });
                
                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-offre-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const offreId = this.getAttribute('data-offre-id');
                        showDeleteModal(offreId);
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
                        renderoffres();
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
                        renderoffres();
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
                            renderoffres();
                        });
                    }
                    
                    paginationContainer.appendChild(pageButton);
                }
            }
            
            // Function to show delete confirmation modal
            function showDeleteModal(offreId) {
                currentoffreIdToDelete = offreId;
                const modal = document.getElementById('delete-modal');
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            // Function to hide delete confirmation modal
            function hideDeleteModal() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                currentoffreIdToDelete = null;
            }
            
            // Function to confirm offre deletion
            async function confirmDeleteoffre() {
                if (!currentoffreIdToDelete) return;
                
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.annonces) {
                        console.error('API client not available');
                        window.showNotification('Erreur lors de la suppression de l\'offre', 'error');
                        hideDeleteModal();
                        return;
                    }
                    
                    // Delete offre from API
                    await window.annonces.delete(currentoffreIdToDelete);
                    
                    // Remove offre from local data
                    offresData = offresData.filter(offre => offre.id != currentoffreIdToDelete);
                    totaloffres--;
                    
                    // Recalculate current page if needed
                    const totalPages = Math.ceil(totaloffres / itemsPerPage);
                    if (currentPage > totalPages && totalPages > 0) {
                        currentPage = totalPages;
                    }
                    
                    // Re-render offres
                    renderoffres();
                    
                    // Show success notification
                    window.showNotification('Offre supprimée avec succès', 'success');
                } catch (error) {
                    console.error('Error deleting offre:', error);
                    window.showNotification('Erreur lors de la suppression de l\'offre', 'error');
                } finally {
                    hideDeleteModal();
                }
            }
            
            // Function to show fallback data when API fails
            function showFallbackData() {
                // Generate sample offres
                offresData = generateSampleoffres();
                totaloffres = offresData.length;
                
                // Render offres
                renderoffres();
            }
            
            // Function to generate sample offres for fallback
            function generateSampleoffres() {
                const now = new Date();
                
                return [
                    {
                        id: 1,
                        titre: 'Développeur Full Stack',
                        description: 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe de développement.',
                        statut: 'ouverte',
                        created_at: new Date(now.getTime() - 5 * 86400000).toISOString(), // 5 days ago
                        applications_count: 12,
                        tags: [
                            { nom: 'JavaScript' },
                            { nom: 'React' },
                            { nom: 'Node.js' },
                            { nom: 'MongoDB' }
                        ]
                    },
                    {
                        id: 2,
                        titre: 'UX Designer',
                        description: 'Poste de UX Designer pour améliorer l\'expérience utilisateur de nos produits.',
                        statut: 'ouverte',
                        created_at: new Date(now.getTime() - 7 * 86400000).toISOString(), // 7 days ago
                        applications_count: 8,
                        tags: [
                            { nom: 'UI/UX' },
                            { nom: 'Figma' },
                            { nom: 'Adobe XD' }
                        ]
                    },
                    {
                        id: 3,
                        titre: 'Chef de Projet Digital',
                        description: 'Gestion de projets digitaux complexes pour nos clients grands comptes.',
                        statut: 'ouverte',
                        created_at: new Date(now.getTime() - 10 * 86400000).toISOString(), // 10 days ago
                        applications_count: 15,
                        tags: [
                            { nom: 'Gestion de projet' },
                            { nom: 'Agile' },
                            { nom: 'Scrum' }
                        ]
                    },
                    {
                        id: 4,
                        titre: 'Data Analyst',
                        description: 'Analyser les données clients pour identifier des tendances et améliorer nos services.',
                        statut: 'fermee',
                        created_at: new Date(now.getTime() - 20 * 86400000).toISOString(), // 20 days ago
                        applications_count: 25,
                        tags: [
                            { nom: 'Python' },
                            { nom: 'SQL' },
                            { nom: 'Tableau' }
                        ]
                    },
                    {
                        id: 5,
                        titre: 'Développeur Mobile',
                        description: 'Développement d\'applications mobiles iOS et Android.',
                        statut: 'brouillon',
                        created_at: new Date(now.getTime() - 2 * 86400000).toISOString(), // 2 days ago
                        applications_count: 0,
                        tags: [
                            { nom: 'Swift' },
                            { nom: 'Kotlin' },
                            { nom: 'Flutter' }
                        ]
                    },
                    {
                        id: 6,
                        titre: 'DevOps Engineer',
                        description: 'Automatisation de l\'infrastructure et mise en place de CI/CD.',
                        statut: 'expiree',
                        created_at: new Date(now.getTime() - 45 * 86400000).toISOString(), // 45 days ago
                        applications_count: 18,
                        tags: [
                            { nom: 'Docker' },
                            { nom: 'Kubernetes' },
                            { nom: 'AWS' }
                        ]
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