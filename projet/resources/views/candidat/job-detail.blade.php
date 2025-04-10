@extends('layouts.app')

@section('title', 'Détail de l\'offre - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ url('/candidat/dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-home"></i>
                                    <span class="sr-only">Accueil</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                <a href="{{ url('/candidat/jobs') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Offres d'emploi</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                <span class="ml-4 text-sm font-medium text-gray-500 truncate" id="job-breadcrumb-title">Détail de l'offre</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <h1 class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl truncate" id="job-title">
                    Chargement...
                </h1>
                
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <i class="fas fa-building mr-1.5 text-gray-400"></i>
                        <span id="job-company">Chargement...</span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock mr-1.5 text-gray-400"></i>
                        <span id="job-date">Chargement...</span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500" id="job-status-container">
                        <span id="job-status" class="px-2 py-1 text-xs rounded-full">Chargement...</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="hidden sm:block">
                    <button id="share-button" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-share-alt -ml-1 mr-2 text-gray-500"></i>
                        Partager
                    </button>
                </span>
                
                <span class="sm:ml-3">
                    <button id="apply-button" type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane -ml-1 mr-2"></i>
                        Postuler
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Loading Spinner (hidden when data loads) -->
    <div id="loading-spinner" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
        <p class="mt-4 text-gray-500">Chargement des détails de l'offre...</p>
    </div>

    <!-- Error Message (hidden by default) -->
    <div id="error-message" class="bg-red-50 border-l-4 border-red-400 p-4 hidden">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    Une erreur est survenue lors du chargement de l'offre. Veuillez réessayer ultérieurement.
                </p>
                <button id="retry-button" class="mt-2 text-sm font-medium text-red-700 hover:text-red-600">
                    Réessayer
                </button>
            </div>
        </div>
    </div>

    <!-- Job Content (hidden until loaded) -->
    <div id="job-content" class="hidden">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Left Column: Job Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Description du poste</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="prose max-w-none" id="job-description">
                            <!-- Job description content will be inserted here -->
                        </div>

                        <!-- Tags Section -->
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500">Compétences requises</h4>
                            <div class="mt-2 flex flex-wrap gap-2" id="job-tags">
                                <!-- Tags will be inserted here -->
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Chargement...
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Company and Application -->
            <div>
                <!-- Company Info -->
                <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">À propos de l'entreprise</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-14 w-14 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold" id="company-name">Chargement...</h4>
                                <p class="text-sm text-gray-500" id="company-location">Chargement...</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4" id="company-description">
                            <!-- Company description will be inserted here -->
                        </p>
                        <a href="#" id="company-website" class="text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            Visiter le site web
                        </a>
                    </div>
                </div>

                <!-- Application Box -->
                <div class="bg-white overflow-hidden shadow rounded-lg sticky top-4">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Postuler</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div id="application-form">
                            <p class="mb-4 text-sm text-gray-600">
                                Intéressé(e) par ce poste ? Postulez dès maintenant pour rejoindre l'équipe.
                            </p>
                            <button id="apply-now-button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Postuler maintenant
                            </button>
                        </div>
                        
                        <div id="already-applied" class="hidden">
                            <div class="rounded-md bg-green-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            Vous avez déjà postulé à cette offre
                                        </p>
                                        <p class="mt-2 text-sm text-green-700">
                                            Votre candidature a été envoyée le <span id="application-date">...</span>
                                        </p>
                                        <div class="mt-4">
                                            <div class="-mx-2 -my-1.5 flex">
                                                <a href="/candidat/applications" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100">
                                                    Voir mes candidatures
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Jobs -->
        <div class="mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Offres similaires</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="similar-jobs-container">
                        <div class="col-span-3 text-center text-gray-500">
                            Chargement des offres similaires...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Modal -->
<div id="application-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-paper-plane text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Postuler à cette offre
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Confirmez-vous votre candidature pour le poste de <strong id="confirm-job-title">...</strong> chez <strong id="confirm-company-name">...</strong> ?
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <div class="border border-gray-300 rounded-md px-3 py-2 shadow-sm">
                                <label for="application-message" class="block text-xs font-medium text-gray-500">
                                    Message (optionnel)
                                </label>
                                <textarea id="application-message" name="message" rows="3" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Partagez votre motivation en quelques mots..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="confirm-application-button" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer
                </button>
                <button id="cancel-application-button" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="share-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="share-modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-share-alt text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="share-modal-title">
                            Partager cette offre d'emploi
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Partagez cette opportunité avec votre réseau
                            </p>
                        </div>
                        
                        <div class="mt-4 flex justify-center space-x-4">
                            <a href="#" id="share-linkedin" class="text-blue-700 hover:text-blue-800">
                                <i class="fab fa-linkedin fa-2x"></i>
                            </a>
                            <a href="#" id="share-twitter" class="text-blue-400 hover:text-blue-500">
                                <i class="fab fa-twitter fa-2x"></i>
                            </a>
                            <a href="#" id="share-facebook" class="text-blue-600 hover:text-blue-700">
                                <i class="fab fa-facebook-square fa-2x"></i>
                            </a>
                            <a href="#" id="share-email" class="text-gray-600 hover:text-gray-700">
                                <i class="fas fa-envelope fa-2x"></i>
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <label for="share-url" class="block text-sm font-medium text-gray-700">
                                Lien direct
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" id="share-url" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" readonly>
                                <button id="copy-url-button" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="close-share-modal-button" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Get job ID from URL
        const jobId = window.location.pathname.split('/').pop();
        
        // DOM elements
        const loadingSpinner = document.getElementById('loading-spinner');
        const errorMessage = document.getElementById('error-message');
        const jobContent = document.getElementById('job-content');
        const retryButton = document.getElementById('retry-button');
        const applyButton = document.getElementById('apply-button');
        const applyNowButton = document.getElementById('apply-now-button');
        const applicationForm = document.getElementById('application-form');
        const alreadyApplied = document.getElementById('already-applied');
        const applicationDate = document.getElementById('application-date');
        const shareButton = document.getElementById('share-button');
        
        // Modal elements
        const applicationModal = document.getElementById('application-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const confirmJobTitle = document.getElementById('confirm-job-title');
        const confirmCompanyName = document.getElementById('confirm-company-name');
        const confirmApplicationButton = document.getElementById('confirm-application-button');
        const cancelApplicationButton = document.getElementById('cancel-application-button');
        const applicationMessage = document.getElementById('application-message');
        
        // Share modal elements
        const shareModal = document.getElementById('share-modal');
        const shareModalBackdrop = document.getElementById('share-modal-backdrop');
        const shareLinkedin = document.getElementById('share-linkedin');
        const shareTwitter = document.getElementById('share-twitter');
        const shareFacebook = document.getElementById('share-facebook');
        const shareEmail = document.getElementById('share-email');
        const shareUrl = document.getElementById('share-url');
        const copyUrlButton = document.getElementById('copy-url-button');
        const closeShareModalButton = document.getElementById('close-share-modal-button');
        
        // Job data
        let jobData = null;
        let userApplications = [];
        let hasApplied = false;
        let applicationDetails = null;
        
        try {
            // Load job data and user applications
            await Promise.all([
                loadJobData(jobId),
                loadUserApplications()
            ]);
            
            // Check if user has already applied
            checkIfApplied();
            
            // Set up event listeners
            setupEventListeners();
            
            // Load similar jobs
            loadSimilarJobs();
        } catch (error) {
            console.error('Error initializing job detail page:', error);
            showError();
        }
        
        // Load job data from API
        async function loadJobData(id) {
            try {
                // Use API client if available
                if (window.annonces) {
                    jobData = await window.annonces.get(id);
                } else {
                    // Fallback to fetch API
                    const response = await fetch(`/api/annonces/${id}`);
                    if (!response.ok) throw new Error('Failed to fetch job');
                    jobData = await response.json();
                }
                
                // Display job data
                displayJobData();
            } catch (error) {
                console.error('Error loading job data:', error);
                showError();
            }
        }
        
        // Load user applications
        async function loadUserApplications() {
            try {
                // Use API client if available
                if (window.candidatures) {
                    userApplications = await window.candidatures.getAll();
                } else {
                    // Fallback to fetch API
                    const response = await fetch('/api/candidatures');
                    if (!response.ok) throw new Error('Failed to fetch applications');
                    userApplications = await response.json();
                }
            } catch (error) {
                console.error('Error loading user applications:', error);
                userApplications = [];
            }
        }
        
        // Check if user has already applied to this job
        function checkIfApplied() {
            if (!jobData || !userApplications.length) return;
            
            const application = userApplications.find(app => app.id_annonce == jobData.id);
            
            if (application) {
                hasApplied = true;
                applicationDetails = application;
                
                // Show already applied message
                applicationForm.classList.add('hidden');
                alreadyApplied.classList.remove('hidden');
                
                // Format application date
                const appDate = new Date(application.created_at);
                applicationDate.textContent = appDate.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                
                // Disable apply buttons
                applyButton.disabled = true;
                applyButton.classList.add('opacity-50', 'cursor-not-allowed');
                applyButton.classList.remove('hover:bg-blue-700');
                applyButton.innerHTML = '<i class="fas fa-check -ml-1 mr-2"></i> Déjà postulé';
            }
        }
        
        // Display job data in UI
        function displayJobData() {
            if (!jobData) return;
            
            // Hide loading spinner, show content
            loadingSpinner.classList.add('hidden');
            jobContent.classList.remove('hidden');
            
            // Update page title
            document.title = `${jobData.titre} - TalentMatcher`;
            
            // Basic job info
            document.getElementById('job-breadcrumb-title').textContent = jobData.titre;
            document.getElementById('job-title').textContent = jobData.titre;
            document.getElementById('job-company').textContent = jobData.recruteur?.name || 'Entreprise';
            
            // Format date
            const postedDate = new Date(jobData.created_at);
            const formattedDate = postedDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('job-date').textContent = `Publié le ${formattedDate}`;
            
            // Status badge
            const statusContainer = document.getElementById('job-status-container');
            const statusBadge = document.getElementById('job-status');
            
            if (jobData.statut === 'ouverte') {
                statusBadge.classList.add('bg-green-100', 'text-green-800');
                statusBadge.textContent = 'Ouverte';
            } else {
                statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
                statusBadge.textContent = 'Fermée';
                
                // Disable apply buttons for closed jobs
                applyButton.disabled = true;
                applyNowButton.disabled = true;
                applyButton.classList.add('opacity-50', 'cursor-not-allowed');
                applyNowButton.classList.add('opacity-50', 'cursor-not-allowed');
                applyButton.classList.remove('hover:bg-blue-700');
                applyNowButton.classList.remove('hover:bg-blue-700');
            }
            
            // Job description
            document.getElementById('job-description').innerHTML = formatDescription(jobData.description);
            
            // Tags
            const tagsContainer = document.getElementById('job-tags');
            tagsContainer.innerHTML = '';
            
            if (jobData.tags && jobData.tags.length) {
                jobData.tags.forEach(tag => {
                    const tagSpan = document.createElement('span');
                    tagSpan.className = 'inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
                    tagSpan.textContent = tag.nom;
                    tagsContainer.appendChild(tagSpan);
                });
            } else {
                const noTagSpan = document.createElement('span');
                noTagSpan.className = 'text-sm text-gray-500';
                noTagSpan.textContent = 'Aucune compétence spécifiée';
                tagsContainer.appendChild(noTagSpan);
            }
            
            // Company info
            document.getElementById('company-name').textContent = jobData.recruteur?.name || 'Entreprise';
            document.getElementById('company-location').textContent = jobData.recruteur?.location || 'France';
            
            // Company description - For demo purposes, we'll generate one if not available
            const companyDesc = jobData.recruteur?.description || 
                `${jobData.recruteur?.name || 'Notre entreprise'} est une société innovante dans son domaine, 
                offrant un environnement de travail stimulant et des opportunités de croissance professionnelle. 
                Nous valorisons la créativité, la collaboration et l'excellence dans tout ce que nous faisons.`;
            
            document.getElementById('company-description').textContent = companyDesc;
            
            // Company website - For demo purposes
            document.getElementById('company-website').href = jobData.recruteur?.website || '#';
            
            // Set up apply modal content
            confirmJobTitle.textContent = jobData.titre;
            confirmCompanyName.textContent = jobData.recruteur?.name || 'l\'entreprise';
            
            // Set up share URL
            shareUrl.value = window.location.href;
            
            // Set up share links
            const shareTitle = encodeURIComponent(`Offre d'emploi: ${jobData.titre} chez ${jobData.recruteur?.name || 'Entreprise'}`);
            const shareDesc = encodeURIComponent(`Découvrez cette opportunité sur TalentMatcher`);
            const shareLink = encodeURIComponent(window.location.href);
            
            shareLinkedin.href = `https://www.linkedin.com/sharing/share-offsite/?url=${shareLink}`;
            shareTwitter.href = `https://twitter.com/intent/tweet?text=${shareTitle}&url=${shareLink}`;
            shareFacebook.href = `https://www.facebook.com/sharer/sharer.php?u=${shareLink}`;
            shareEmail.href = `mailto:?subject=${shareTitle}&body=${shareDesc}%0A%0A${shareLink}`;
        }
        
        // Format job description (convert newlines to paragraphs)
        function formatDescription(description) {
            if (!description) return '<p>Aucune description disponible.</p>';
            
            return description
                .split('\n\n')
                .map(paragraph => `<p>${paragraph.replace(/\n/g, '<br>')}</p>`)
                .join('');
        }
        
        // Show error message
        function showError() {
            loadingSpinner.classList.add('hidden');
            errorMessage.classList.remove('hidden');
        }
        
        // Set up event listeners
        function setupEventListeners() {
            // Retry button
            retryButton.addEventListener('click', async function() {
                errorMessage.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
                
                try {
                    await loadJobData(jobId);
                    await loadUserApplications();
                    checkIfApplied();
                    loadSimilarJobs();
                } catch (error) {
                    console.error('Error retrying:', error);
                    showError();
                }
            });
            
            // Apply buttons
            applyButton.addEventListener('click', showApplicationModal);
            applyNowButton.addEventListener('click', showApplicationModal);
            
            // Application modal
            cancelApplicationButton.addEventListener('click', hideApplicationModal);
            modalBackdrop.addEventListener('click', hideApplicationModal);
            
            confirmApplicationButton.addEventListener('click', submitApplication);
            
            // Share button
            shareButton.addEventListener('click', showShareModal);
            
            // Share modal
            closeShareModalButton.addEventListener('click', hideShareModal);
            shareModalBackdrop.addEventListener('click', hideShareModal);
            
            // Copy URL button
            copyUrlButton.addEventListener('click', copyShareUrl);
        }
        
        // Show application modal
        function showApplicationModal() {
            if (hasApplied || jobData.statut !== 'ouverte') return;
            
            applicationModal.classList.remove('hidden');
            confirmApplicationButton.disabled = false;
            applicationMessage.value = '';
        }
        
        // Hide application modal
        function hideApplicationModal() {
            applicationModal.classList.add('hidden');
        }
        
        // Show share modal
        function showShareModal() {
            shareModal.classList.remove('hidden');
        }
        
        // Hide share modal
        function hideShareModal() {
            shareModal.classList.add('hidden');
        }
        
        // Copy share URL to clipboard
        function copyShareUrl() {
            shareUrl.select();
            document.execCommand('copy');
            
            // Show copied notification
            const originalText = copyUrlButton.innerHTML;
            copyUrlButton.innerHTML = '<i class="fas fa-check"></i>';
            
            setTimeout(() => {
                copyUrlButton.innerHTML = originalText;
            }, 2000);
        }
        
        // Submit application
        async function submitApplication() {
            if (hasApplied || !jobData || jobData.statut !== 'ouverte') return;
            
            // Disable button to prevent multiple submissions
            confirmApplicationButton.disabled = true;
            confirmApplicationButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Envoi en cours...';
            
            try {
                // Use API client if available
                if (window.candidatures) {
                    const message = applicationMessage.value.trim();
                    const data = {
                        id_annonce: jobData.id,
                        message: message || null
                    };
                    
                    await window.candidatures.create(jobData.id);
                    
                    // Update UI
                    hasApplied = true;
                    
                    // Hide modal
                    hideApplicationModal();
                    
                    // Show success notification
                    if (window.showNotification) {
                        window.showNotification('Votre candidature a été envoyée avec succès !', 'success');
                    }
                    
                    // Update application status
                    applicationForm.classList.add('hidden');
                    alreadyApplied.classList.remove('hidden');
                    
                    // Format application date
                    const now = new Date();
                    applicationDate.textContent = now.toLocaleDateString('fr-FR', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    // Disable apply buttons
                    applyButton.disabled = true;
                    applyButton.classList.add('opacity-50', 'cursor-not-allowed');
                    applyButton.classList.remove('hover:bg-blue-700');
                    applyButton.innerHTML = '<i class="fas fa-check -ml-1 mr-2"></i> Déjà postulé';
                } else {
                    // Fallback for demo
                    setTimeout(() => {
                        // Hide modal
                        hideApplicationModal();
                        
                        // Show success message
                        if (window.showNotification) {
                            window.showNotification('Votre candidature a été envoyée avec succès !', 'success');
                        }
                        
                        // Update application status
                        hasApplied = true;
                        applicationForm.classList.add('hidden');
                        alreadyApplied.classList.remove('hidden');
                        
                        // Format application date
                        const now = new Date();
                        applicationDate.textContent = now.toLocaleDateString('fr-FR', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        
                        // Disable apply buttons
                        applyButton.disabled = true;
                        applyButton.classList.add('opacity-50', 'cursor-not-allowed');
                        applyButton.classList.remove('hover:bg-blue-700');
                        applyButton.innerHTML = '<i class="fas fa-check -ml-1 mr-2"></i> Déjà postulé';
                    }, 1500);
                }
            } catch (error) {
                console.error('Error submitting application:', error);
                
                // Reset button
                confirmApplicationButton.disabled = false;
                confirmApplicationButton.innerHTML = 'Confirmer';
                
                // Show error notification
                if (window.showNotification) {
                    window.showNotification('Une erreur est survenue lors de l\'envoi de votre candidature. Veuillez réessayer.', 'error');
                }
            }
        }
        
        // Load similar jobs
        async function loadSimilarJobs() {
            if (!jobData) return;
            
            const container = document.getElementById('similar-jobs-container');
            container.innerHTML = '';
            
            try {
                let similarJobs = [];
                
                // Use API client if available
                if (window.annonces) {
                    const allJobs = await window.annonces.getAll();
                    
                    // Filter out current job and get jobs with similar tags
                    similarJobs = allJobs
                        .filter(job => job.id !== jobData.id && job.statut === 'ouverte')
                        .sort(() => 0.5 - Math.random()) // Shuffle
                        .slice(0, 3); // Take top 3
                } else {
                    // Generate sample similar jobs
                    similarJobs = generateSampleSimilarJobs();
                }
                
                if (similarJobs.length === 0) {
                    container.innerHTML = `
                        <div class="col-span-3 text-center text-gray-500">
                            Aucune offre similaire disponible pour le moment.
                        </div>
                    `;
                    return;
                }
                
                // Create job cards
                similarJobs.forEach(job => {
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
                                ${job.tags.slice(0, 2).map(tag => 
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
            } catch (error) {
                console.error('Error loading similar jobs:', error);
                container.innerHTML = `
                    <div class="col-span-3 text-center text-gray-500">
                        Erreur lors du chargement des offres similaires.
                    </div>
                `;
            }
        }
        
        // Generate sample similar jobs for demo
        function generateSampleSimilarJobs() {
            const titles = [
                'Développeur Full Stack', 
                'Designer UX/UI', 
                'Chef de Projet IT'
            ];
            
            const companies = [
                'TechCorp', 
                'DesignStudio', 
                'DataWorks'
            ];
            
            const descriptions = [
                'Nous recherchons un développeur expérimenté pour rejoindre notre équipe dynamique...',
                'Poste passionnant au sein d\'une entreprise innovante dans le secteur de la tech...',
                'Rejoignez notre équipe de professionnels dédiés et contribuez à des projets d\'envergure...'
            ];
            
            // Generate sample tags
            const allTags = [
                { id: 1, nom: 'JavaScript' },
                { id: 2, nom: 'PHP' },
                { id: 3, nom: 'React' },
                { id: 4, nom: 'Laravel' },
                { id: 5, nom: 'UI/UX' }
            ];
            
            // Generate 3 sample jobs
            return Array.from({ length: 3 }, (_, i) => {
                const date = new Date();
                date.setDate(date.getDate() - Math.floor(Math.random() * 30));
                
                // Select 2 random tags
                const jobTags = [
                    allTags[Math.floor(Math.random() * allTags.length)],
                    allTags[Math.floor(Math.random() * allTags.length)]
                ];
                
                return {
                    id: 100 + i,
                    titre: titles[i],
                    description: descriptions[i],
                    statut: 'ouverte',
                    created_at: date.toISOString(),
                    recruteur: {
                        name: companies[i]
                    },
                    tags: jobTags
                };
            });
        }
    });
</script>
@endsection