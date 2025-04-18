@extends('layouts.app')

@section('title', 'Offres d\'emploi - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Offres d'emploi</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0">
        <!-- Search & Filters -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Bar -->
                    <div class="md:col-span-4">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search-input" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher par titre, entreprise ou compétence...">
                        </div>
                    </div>

                    <!-- Sector Filter -->
                    <div>
                        <label for="sector-filter" class="block text-sm font-medium text-gray-700 mb-1">Secteur</label>
                        <select id="sector-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Tous les secteurs</option>
                            <option value="informatique">Informatique</option>
                            <option value="marketing">Marketing</option>
                            <option value="finance">Finance</option>
                            <option value="rh">Ressources Humaines</option>
                            <option value="design">Design</option>
                        </select>
                    </div>

                    <!-- Tag Filter -->
                    <div>
                        <label for="tag-filter" class="block text-sm font-medium text-gray-700 mb-1">Compétence</label>
                        <select id="tag-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Toutes les compétences</option>
                            <!-- Will be populated dynamically -->
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="ouverte">Ouvertes</option>
                            <option value="fermée">Fermées</option>
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div>
                        <label for="sort-filter" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select id="sort-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="date-desc">Plus récentes</option>
                            <option value="date-asc">Plus anciennes</option>
                            <option value="title-asc">Titre (A-Z)</option>
                            <option value="title-desc">Titre (Z-A)</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button id="reset-filters-btn" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réinitialiser
                    </button>
                    <button id="apply-filters-btn" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Appliquer les filtres
                    </button>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Résultats
                        </h3>
                        <p class="mt-1 text-sm text-gray-500" id="jobs-count">
                            Chargement des offres...
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <span id="job-pagination-info" class="text-sm text-gray-500">
                            Page 1
                        </span>
                    </div>
                </div>
            </div>
            
            <div id="jobs-container" class="divide-y divide-gray-200">
                <div class="p-6 text-center text-gray-500">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                    Chargement des offres d'emploi...
                </div>
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

<!-- Job Card Template (hidden) -->
<template id="job-card-template">
    <div class="job-card p-6 hover:bg-gray-50 transition-colors duration-150">
        <div class="flex flex-col md:flex-row md:items-start">
            <div class="flex-1">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-12 w-12 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                        <i class="fas fa-briefcase text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">
                            <a href="#" class="job-title text-blue-600 hover:text-blue-800">Titre du poste</a>
                        </h3>
                        <div class="mt-1 flex items-center text-sm text-gray-500">
                            <i class="fas fa-building mr-1.5"></i>
                            <span class="job-company">Nom de l'entreprise</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 job-description text-sm text-gray-700 line-clamp-2"></div>
                
                <div class="mt-4 flex flex-wrap gap-2 job-tags"></div>
            </div>
            
            <div class="mt-4 md:mt-0 md:ml-6 flex flex-col items-end justify-between">
                <div class="text-right">
                    <span class="job-status px-2 py-1 text-xs rounded-full"></span>
                </div>
                <div class="mt-4 text-sm text-gray-500 job-date">Date de publication</div>
                <a href="#" class="job-link mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
        let allJobs = [];
        let filteredJobs = [];
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
        const jobsContainer = document.getElementById('jobs-container');
        const jobsCount = document.getElementById('jobs-count');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const prevPageMobileBtn = document.getElementById('prev-page-mobile');
        const nextPageMobileBtn = document.getElementById('next-page-mobile');
        const paginationContainer = document.getElementById('pagination-container');
        const resultRange = document.getElementById('result-range');
        const totalResults = document.getElementById('total-results');
        const jobPaginationInfo = document.getElementById('job-pagination-info');
                
        try {
            // Fetch jobs and tags
            await Promise.all([
                fetchJobs(),
                fetchTags()
            ]);
            
            // Set up event listeners
            setupEventListeners();
            
            // Initially apply current filters
            applyFilters();
        } catch (error) {
            console.error('Error initializing job search:', error);
            showError('Une erreur est survenue lors du chargement des offres d\'emploi.');
        }
        
        // Fetch all jobs from API
        async function fetchJobs() {
            try {
                // Use API client if available
                if (window.annonces) {
                    allJobs = await window.annonces.getAll();
                } else {
                    // Fallback to fetch API
                    const response = await fetch('/api/annonces');
                    if (!response.ok) throw new Error('Failed to fetch jobs');
                    allJobs = await response.json();
                }
                
                // Initial filtering
                filteredJobs = [...allJobs];
            } catch (error) {
                console.error('Error fetching jobs:', error);
                // Fallback with sample data
                allJobs = generateSampleJobs();
                filteredJobs = [...allJobs];
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
                    renderJobs();
                    updatePagination();
                }
            });
            
            nextPageBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredJobs.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderJobs();
                    updatePagination();
                }
            });
            
            // Mobile pagination
            prevPageMobileBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderJobs();
                    updatePagination();
                }
            });
            
            nextPageMobileBtn.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredJobs.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderJobs();
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
            
            // Filter jobs
            filteredJobs = allJobs.filter(job => {
                // Search term (title, company, description)
                const titleMatch = job.titre?.toLowerCase().includes(searchTerm);
                const companyMatch = job.recruteur?.name?.toLowerCase().includes(searchTerm);
                const descriptionMatch = job.description?.toLowerCase().includes(searchTerm);
                
                if (searchTerm && !(titleMatch || companyMatch || descriptionMatch)) {
                    return false;
                }
                
                // Sector (simulated - would need backend support)
                if (sector && job.secteur !== sector) {
                    // If secteur property doesn't exist, assume it's the Informatique sector for this demo
                    if (sector !== 'informatique') {
                        return false;
                    }
                }
                
                // Tag filter
                if (tagId) {
                    const hasTag = job.tags && job.tags.some(tag => tag.id === tagId);
                    if (!hasTag) return false;
                }
                
                // Status filter
                if (status && job.statut !== status) {
                    return false;
                }
                
                return true;
            });
            
            // Sort jobs
            sortJobs(sortBy);
            
            // Reset to first page
            currentPage = 1;
            
            // Render results
            renderJobs();
            updatePagination();
        }
        
        // Sort jobs based on selected criteria
        function sortJobs(sortBy) {
            switch (sortBy) {
                case 'date-desc':
                    filteredJobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
                case 'date-asc':
                    filteredJobs.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    break;
                case 'title-asc':
                    filteredJobs.sort((a, b) => a.titre.localeCompare(b.titre));
                    break;
                case 'title-desc':
                    filteredJobs.sort((a, b) => b.titre.localeCompare(a.titre));
                    break;
                default:
                    break;
            }
        }
        
        // Render job listings with pagination
        function renderJobs() {
            // Clear container
            jobsContainer.innerHTML = '';
            
            // Update count
            jobsCount.textContent = `${filteredJobs.length} offre(s) trouvée(s)`;
            
            if (filteredJobs.length === 0) {
                jobsContainer.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        Aucune offre ne correspond à vos critères. Veuillez modifier vos filtres.
                    </div>
                `;
                return;
            }
            
            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredJobs.length);
            const currentJobs = filteredJobs.slice(startIndex, endIndex);
            
            // Update display range
            resultRange.textContent = `${startIndex + 1} à ${endIndex}`;
            totalResults.textContent = filteredJobs.length;
            jobPaginationInfo.textContent = `Page ${currentPage} sur ${Math.ceil(filteredJobs.length / itemsPerPage)}`;
            
            // Get template
            const template = document.getElementById('job-card-template');
            
            // Create job cards
            currentJobs.forEach(job => {
                const card = document.importNode(template.content, true);
                
                // Fill in data
                const titleLink = card.querySelector('.job-title');
                titleLink.textContent = job.titre;
                titleLink.href = `/candidat/jobs/${job.id}`;
                
                card.querySelector('.job-company').textContent = job.recruteur?.name || 'Entreprise';
                card.querySelector('.job-description').textContent = job.description;
                
                // Format date
                const postedDate = new Date(job.created_at);
                const formattedDate = postedDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                card.querySelector('.job-date').textContent = `Publié le ${formattedDate}`;
                
                // Job link
                const jobLink = card.querySelector('.job-link');
                jobLink.href = `/candidat/jobs/${job.id}`;
                
                // Status badge
                const statusBadge = card.querySelector('.job-status');
                if (job.statut === 'ouverte') {
                    statusBadge.classList.add('bg-green-100', 'text-green-800');
                    statusBadge.textContent = 'Ouverte';
                } else {
                    statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
                    statusBadge.textContent = 'Fermée';
                }
                
                // Tags
                const tagsContainer = card.querySelector('.job-tags');
                if (job.tags && job.tags.length) {
                    job.tags.forEach(tag => {
                        const tagSpan = document.createElement('span');
                        tagSpan.className = 'px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full';
                        tagSpan.textContent = tag.nom;
                        tagsContainer.appendChild(tagSpan);
                    });
                }
                
                // Add to container
                jobsContainer.appendChild(card);
            });
            
            // Scroll to top
            window.scrollTo(0, 0);
        }
        
        // Update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredJobs.length / itemsPerPage);
            
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
                    renderJobs();
                    updatePagination();
                });
                
                // Insert before next button
                paginationContainer.insertBefore(button, nextPageBtn);
            }
        }
        
        // Show error message
        function showError(message) {
            jobsContainer.innerHTML = `
                <div class="p-6 text-center text-red-500">
                    <i class="fas fa-exclamation-circle text-3xl mb-4"></i>
                    <p>${message}</p>
                    <button id="retry-button" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réessayer
                    </button>
                </div>
            `;
            
            document.getElementById('retry-button').addEventListener('click', async function() {
                jobsContainer.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div>
                        Chargement des offres d'emploi...
                    </div>
                `;
                
                try {
                    await fetchJobs();
                    await fetchTags();
                    applyFilters();
                } catch (error) {
                    console.error('Error retrying:', error);
                    showError('Une erreur est survenue lors du chargement des offres d\'emploi.');
                }
            });
        }
        
        // Generate sample jobs data for fallback
        function generateSampleJobs() {
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
            
            // Generate 30 sample jobs
            return Array.from({ length: 30 }, (_, i) => {
                const date = new Date();
                date.setDate(date.getDate() - Math.floor(Math.random() * 30));
                
                // Select 2-3 random tags
                const jobTags = [];
                const numTags = Math.floor(Math.random() * 2) + 2;
                const tagIndices = new Set();
                
                while (tagIndices.size < numTags) {
                    tagIndices.add(Math.floor(Math.random() * tags.length));
                }
                
                tagIndices.forEach(index => {
                    jobTags.push(tags[index]);
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
                    tags: jobTags
                };
            });
        }
    });
</script>
@endsection