@extends('layouts.nav')

@section('title', 'Offres d\'emploi')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0">
        <!-- Search & Filters -->
<form action="{{ route('candidat.offres') }}" method="GET" class="bg-white overflow-hidden shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Bar -->
            <div class="md:col-span-4">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="keywords" value="{{ request('keywords') }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher par titre, entreprise ou compétence...">
                </div>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Secteur</label>
                <select name="category" id="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Tous les secteurs</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Compétence</label>
                <select name="tags[]" id="tags" multiple class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Toutes les compétences</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, request('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="ouverte" {{ request('status') == 'ouverte' ? 'selected' : '' }}>Ouvertes</option>
                    <option value="fermée" {{ request('status') == 'fermée' ? 'selected' : '' }}>Fermées</option>
                </select>
            </div>

            <!-- Sort Filter -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                <select name="sort_field" id="sort" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="created_at" {{ request('sort_field') == 'created_at' ? 'selected' : '' }}>Date</option>
                    <option value="title" {{ request('sort_field') == 'title' ? 'selected' : '' }}>Titre</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ route('candidat.offres') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Réinitialiser
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#ea530c] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Appliquer les filtres
            </button>
        </div>
    </div>
</form>

        <!-- Results -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Résultats
                        </h3>
                        <p class="mt-1 text-sm text-gray-500" id="offres-count">
                            Chargement des offres...
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <span id="offre-pagination-info" class="text-sm text-gray-500">
                            Page 1
                        </span>
                    </div>
                </div>
            </div>
            
            <div id="offres-container" class="divide-y divide-gray-200">
                @if($offres->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        Aucune offre d'emploi n'est actuellement disponible.
                    </div>
                @else
                    @foreach($offres as $offre)
                        <div class="offre-card p-6 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex flex-col md:flex-row md:items-start">
                                <div class="flex-1">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                                            <i class="fas fa-briefcase text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold">
                                                <a href="{{ route('candidat.offre.detail', $offre->id) }}" class="text-blue-600 hover:text-blue-800">{{ $offre->titre }}</a>
                                            </h3>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-building mr-1.5"></i>
                                                <span>{{ $offre->recruteur->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 offre-description text-sm text-gray-700 line-clamp-2">
                                        {{ Str::limit($offre->description, 150) }}
                                    </div>
                                    
                                    <div class="mt-4 flex flex-wrap gap-2 offre-tags">
                                        @if($offre->tags)
                                            @foreach($offre->tags as $tag)
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $tag->nom }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-4 md:mt-0 md:ml-6 flex flex-col items-end justify-between">
                                    <div class="text-right">
                                        <span class="offre-status px-2 py-1 text-xs rounded-full {{ $offre->statut === 'ouverte' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($offre->statut) }}
                                        </span>
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $offre->location }}
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <i class="fas fa-euro-sign mr-1"></i>
                                        {{ number_format($offre->salaire, 2) }} €
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $offre->created_at->format('d/m/Y') }}
                                    </div>
                                    <a href="{{ route('candidat.offre.detail', $offre->id) }}" class="offre-link mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Voir l'offre
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            @if($offres->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button onclick="document.location='{{ $offres->previousPageUrl() }}'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 {{ !$offres->onFirstPage() ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}">
                        Précédent
                    </button>
                    <button onclick="document.location='{{ $offres->nextPageUrl() }}'" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 {{ !$offres->hasMorePages() ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}">
                        Suivant
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage des offres
                            <span class="font-medium">{{ $offres->firstItem() }}</span>
                            à
                            <span class="font-medium">{{ $offres->lastItem() }}</span>
                            sur
                            <span class="font-medium">{{ $offres->total() }}</span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button onclick="document.location='{{ $offres->previousPageUrl() }}'" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ !$offres->onFirstPage() ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            @for($i = 1; $i <= $offres->lastPage(); $i++)
                                <button onclick="document.location='{{ $offres->url($i) }}'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium {{ $i == $offres->currentPage() ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                                    {{ $i }}
                                </button>
                            @endfor
                            <button onclick="document.location='{{ $offres->nextPageUrl() }}'" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ !$offres->hasMorePages() ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}">
                                <span class="sr-only">Suivant</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- offre Card Template (hidden) -->
<template id="offre-card-template">
    <div class="offre-card p-6 hover:bg-gray-50 transition-colors duration-150">
        <div class="flex flex-col md:flex-row md:items-start">
            <div class="flex-1">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-12 w-12 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                        <i class="fas fa-briefcase text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">
                            <a href="#" class="offre-title text-blue-600 hover:text-blue-800">Titre du poste</a>
                        </h3>
                        <div class="mt-1 flex items-center text-sm text-gray-500">
                            <i class="fas fa-building mr-1.5"></i>
                            <span class="offre-company">Nom de l'entreprise</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 offre-description text-sm text-gray-700 line-clamp-2"></div>
                
                <div class="mt-4 flex flex-wrap gap-2 offre-tags"></div>
            </div>
            
            <div class="mt-4 md:mt-0 md:ml-6 flex flex-col items-end justify-between">
                <div class="text-right">
                    <span class="offre-status px-2 py-1 text-xs rounded-full"></span>
                </div>
                <div class="mt-4 text-sm text-gray-500 offre-date">Date de publication</div>
                <a href="#" class="offre-link mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Voir l'offre
                </a>
            </div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // State variables
        let alloffres = [];
        let filteredoffres = [];
        let allTags = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        
        // Cache DOM elements
        const searchInput = document.getElementById('search-input');
        const sectorFilter = document.getElementById('sector-filter');
        const tagFilter = document.getElementById('tag-filter');
        const statusFilter = document.getElementById('status-filter');
        const sortFilter = document.getElementById('sort-filter');
        const resetFiltersBtn = document.getElementById('reset-filters-btn');
        const applyFiltersBtn = document.getElementById('apply-filters-btn');
        const offresContainer = document.getElementById('offres-container');
        const offresCount = document.getElementById('offres-count');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const prevPageMobileBtn = document.getElementById('prev-page-mobile');
        const nextPageMobileBtn = document.getElementById('next-page-mobile');
        const paginationContainer = document.getElementById('pagination-container');
        const resultRange = document.getElementById('result-range');
        const totalResults = document.getElementById('total-results');
        const offrePaginationInfo = document.getElementById('offre-pagination-info');
                
        try {
            // Fetch offres and tags
            await Promise.all([
                fetchoffres(),
                fetchTags()
            ]);
            
            // Set up event listeners
            setupEventListeners();
            
            // Initially apply current filters
            applyFilters();
        } catch (error) {
            console.error('Error initializing offre search:', error);
            showError('Une erreur est survenue lors du chargement des offres d\'emploi.');
        }
        
        // Fetch all offres from API
        async function fetchoffres() {
            try {
                // Use API client if available
                if (window.annonces) {
                    alloffres = await window.annonces.getAll();
                } else {
                    // Fallback to fetch API
                    const response = await fetch('/api/annonces');
                    if (!response.ok) throw new Error('Failed to fetch offres');
                    alloffres = await response.json();
                }
                
                // Initial filtering
                filteredoffres = [...alloffres];
            } catch (error) {
                console.error('Error fetching offres:', error);
                // Fallback with sample data
                alloffres = generateSampleoffres();
                filteredoffres = [...alloffres];
            }
        }
        
        // Fetch all tags from API
        async function fetchTags() {
            try {
                // Use API client if available
                if (window.apiClient) {
                    allTags = await window.apiClient.get('/tags');
                } else {
                    // Fallback to fetch API
                    const response = await fetch('/api/tags');
                    if (!response.ok) throw new Error('Failed to fetch tags');
                    allTags = await response.json();
                }
                
                // Populate tag filter
                populateTagFilter();
            } catch (error) {
                console.error('Error fetching tags:', error);
                // Fallback with sample tags
                allTags = [
                    { id: 1, nom: 'JavaScript' },
                    { id: 2, nom: 'PHP' },
                    { id: 3, nom: 'React' },
                    { id: 4, nom: 'Laravel' },
                    { id: 5, nom: 'UI/UX' },
                    { id: 6, nom: 'SQL' }
                ];
                populateTagFilter();
            }
        }
        
        // Populate tag filter dropdown
        function populateTagFilter() {
            const select = document.getElementById('tag-filter');
            
            // Clear existing options (except first)
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Add tag options
            allTags.forEach(tag => {
                const option = document.createElement('option');
                option.value = tag.id;
                option.textContent = tag.nom;
                select.appendChild(option);
            });
        }
        
        // Set up event listeners
        function setupEventListeners() {
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
            applyFiltersBtn.addEventListener('click', function() {
                currentPage = 1;
                applyFilters();
            });
            
            // Reset filters
            resetFiltersBtn.addEventListener('click', function() {
                searchInput.value = '';
                sectorFilter.value = '';
                tagFilter.value = '';
                statusFilter.value = '';
                sortFilter.value = 'date-desc';
                
                currentPage = 1;
                applyFilters();
            });
            
            // Pagination
            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderoffres();
                    updatePagination();
                }
            });
            
            nextPageBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredoffres.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderoffres();
                    updatePagination();
                }
            });
            
            // Mobile pagination
            prevPageMobileBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderoffres();
                    updatePagination();
                }
            });
            
            nextPageMobileBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredoffres.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderoffres();
                    updatePagination();
                }
            });
        }
        
        // Apply filters and sort
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const sector = sectorFilter.value;
            const tagId = parseInt(tagFilter.value) || null;
            const status = statusFilter.value;
            const sortBy = sortFilter.value;
            
            // Filter offres
            filteredoffres = alloffres.filter(offre => {
                // Search term (title, company, description)
                const titleMatch = offre.titre?.toLowerCase().includes(searchTerm);
                const companyMatch = offre.recruteur?.name?.toLowerCase().includes(searchTerm);
                const descriptionMatch = offre.description?.toLowerCase().includes(searchTerm);
                
                if (searchTerm && !(titleMatch || companyMatch || descriptionMatch)) {
                    return false;
                }
                
                // Sector (simulated - would need backend support)
                if (sector && offre.secteur !== sector) {
                    // If secteur property doesn't exist, assume it's the Informatique sector for this demo
                    if (sector !== 'informatique') {
                        return false;
                    }
                }
                
                // Tag filter
                if (tagId) {
                    const hasTag = offre.tags && offre.tags.some(tag => tag.id === tagId);
                    if (!hasTag) return false;
                }
                
                // Status filter
                if (status && offre.statut !== status) {
                    return false;
                }
                
                return true;
            });
            
            // Sort offres
            sortoffres(sortBy);
            
            // Reset to first page
            currentPage = 1;
            
            // Render results
            renderoffres();
            updatePagination();
        }
        
        // Sort offres based on selected criteria
        function sortoffres(sortBy) {
            switch (sortBy) {
                case 'date-desc':
                    filteredoffres.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
                case 'date-asc':
                    filteredoffres.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    break;
                case 'title-asc':
                    filteredoffres.sort((a, b) => a.titre.localeCompare(b.titre));
                    break;
                case 'title-desc':
                    filteredoffres.sort((a, b) => b.titre.localeCompare(a.titre));
                    break;
                default:
                    break;
            }
        }
        
        // Render offre listings with pagination
        function renderoffres() {
            // Clear container
            offresContainer.innerHTML = '';
            
            // Update count
            offresCount.textContent = `${filteredoffres.length} offre(s) trouvée(s)`;
            
            if (filteredoffres.length === 0) {
                offresContainer.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        Aucune offre ne correspond à vos critères. Veuillez modifier vos filtres.
                    </div>
                `;
                return;
            }
            
            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredoffres.length);
            const currentoffres = filteredoffres.slice(startIndex, endIndex);
            
            // Update display range
            resultRange.textContent = `${startIndex + 1} à ${endIndex}`;
            totalResults.textContent = filteredoffres.length;
            offrePaginationInfo.textContent = `Page ${currentPage} sur ${Math.ceil(filteredoffres.length / itemsPerPage)}`;
            
            // Get template
            const template = document.getElementById('offre-card-template');
            
            // Create offre cards
            currentoffres.forEach(offre => {
                const card = document.importNode(template.content, true);
                
                // Fill in data
                const titleLink = card.querySelector('.offre-title');
                titleLink.textContent = offre.titre;
                titleLink.href = `/candidat/offres/${offre.id}`;
                
                card.querySelector('.offre-company').textContent = offre.recruteur?.name || 'Entreprise';
                card.querySelector('.offre-description').textContent = offre.description;
                
                // Format date
                const postedDate = new Date(offre.created_at);
                const formattedDate = postedDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                card.querySelector('.offre-date').textContent = `Publié le ${formattedDate}`;
                
                // offre link
                const offreLink = card.querySelector('.offre-link');
                offreLink.href = `/candidat/offres/${offre.id}`;
                
                // Status badge
                const statusBadge = card.querySelector('.offre-status');
                if (offre.statut === 'ouverte') {
                    statusBadge.classList.add('bg-green-100', 'text-green-800');
                    statusBadge.textContent = 'Ouverte';
                } else {
                    statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
                    statusBadge.textContent = 'Fermée';
                }
                
                // Tags
                const tagsContainer = card.querySelector('.offre-tags');
                if (offre.tags && offre.tags.length) {
                    offre.tags.forEach(tag => {
                        const tagSpan = document.createElement('span');
                        tagSpan.className = 'px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full';
                        tagSpan.textContent = tag.nom;
                        tagsContainer.appendChild(tagSpan);
                    });
                }
                
                // Add to container
                offresContainer.appendChild(card);
            });
            
            // Scroll to top
            window.scrollTo(0, 0);
        }
        
        // Update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredoffres.length / itemsPerPage);
            
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
                    renderoffres();
                    updatePagination();
                });
                
                // Insert before next button
                paginationContainer.insertBefore(button, nextPageBtn);
            }
        }
        
        // Show error message
        function showError(message) {
            offresContainer.innerHTML = `
                <div class="p-6 text-center text-red-500">
                    <i class="fas fa-exclamation-circle text-3xl mb-4"></i>
                    <p>${message}</p>
                    <button id="retry-button" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réessayer
                    </button>
                </div>
            `;
            
            document.getElementById('retry-button').addEventListener('click', async function() {
                offresContainer.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                        Chargement des offres d'emploi...
                    </div>
                `;
                
                try {
                    await fetchoffres();
                    await fetchTags();
                    applyFilters();
                } catch (error) {
                    console.error('Error retrying:', error);
                    showError('Une erreur est survenue lors du chargement des offres d\'emploi.');
                }
            });
        }
        
        // Generate sample offres data for fallback
        function generateSampleoffres() {
            const titles = [
                'Développeur Full Stack', 
                'Designer UX/UI', 
                'Chef de Projet', 
                'Data Scientist', 
                'DevOps Engineer',
                'Développeur Front-End',
                'Développeur Back-End',
                'Product Manager',
                'UI Designer',
                'Développeur Mobile',
                'Data Analyst',
                'Développeur Python',
                'Ingénieur QA',
                'Architecte Cloud',
                'Growth Hacker'
            ];
            
            const companies = [
                'TechCorp', 
                'DesignStudio', 
                'DataWorks', 
                'WebSolutions', 
                'CloudTech',
                'AgileWorks',
                'CreativeLab',
                'WebTech',
                'DataInsights',
                'MobileDev',
                'TechInnovate',
                'CodeSquad',
                'TestingPro',
                'CloudSolutions',
                'GrowthGenius'
            ];
            
            const descriptions = [
                'Nous recherchons un développeur expérimenté pour rejoindre notre équipe dynamique...',
                'Poste passionnant au sein d\'une entreprise innovante dans le secteur de la tech...',
                'Rejoignez notre équipe de professionnels dédiés et contribuez à des projets d\'envergure...',
                'Opportunité unique de travailler sur des projets à la pointe de la technologie...',
                'Idéal pour un professionnel cherchant à relever de nouveaux défis dans un environnement stimulant...'
            ];
            
            const tags = [
                { id: 1, nom: 'JavaScript' },
                { id: 2, nom: 'PHP' },
                { id: 3, nom: 'React' },
                { id: 4, nom: 'Laravel' },
                { id: 5, nom: 'UI/UX' },
                { id: 6, nom: 'SQL' }
            ];
            
            // Generate 30 sample offres
            return Array.from({ length: 30 }, (_, i) => {
                const date = new Date();
                date.setDate(date.getDate() - Math.floor(Math.random() * 30));
                
                // Select 2-3 random tags
                const offreTags = [];
                const numTags = Math.floor(Math.random() * 2) + 2;
                const tagIndices = new Set();
                
                while (tagIndices.size < numTags) {
                    tagIndices.add(Math.floor(Math.random() * tags.length));
                }
                
                tagIndices.forEach(index => {
                    offreTags.push(tags[index]);
                });
                
                return {
                    id: i + 1,
                    titre: titles[i % titles.length],
                    description: descriptions[i % descriptions.length],
                    statut: Math.random() > 0.2 ? 'ouverte' : 'fermée',
                    created_at: date.toISOString(),
                    updated_at: date.toISOString(),
                    recruteur: {
                        id: i + 1,
                        name: companies[i % companies.length]
                    },
                    tags: offreTags
                };
            });
        }
    });
</script>
@endsection