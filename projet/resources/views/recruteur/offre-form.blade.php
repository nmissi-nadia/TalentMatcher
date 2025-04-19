@extends('layouts.app')

@section('title', isset($offre) ? 'Modifier une offre - TalentMatcher' : 'Créer une offre - TalentMatcher')

@section('content')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ isset($offre) ? 'Modifier l\'offre d\'emploi' : 'Publier une nouvelle offre d\'emploi' }}
        </h1>
    </div>
</div>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form id="offre-form" class="space-y-6 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                    <!-- Hidden offre ID for edit mode -->
                    <input type="hidden" id="offre-id" value="{{ isset($offre) ? $offre->id : '' }}">
                    
                    <!-- offre Title -->
                    <div class="sm:col-span-6">
                        <label for="offre-title" class="block text-sm font-medium text-gray-700">
                            Titre du poste <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" id="offre-title" name="titre" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="ex: Développeur Full Stack JavaScript">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Un titre clair et concis qui décrit le poste (Max. 100 caractères)
                        </p>
                    </div>

                    <!-- offre Location -->
                    <div class="sm:col-span-3">
                        <label for="offre-location" class="block text-sm font-medium text-gray-700">
                            Lieu <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" id="offre-location" name="lieu" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="ex: Paris, France">
                        </div>
                    </div>

                    <!-- offre Type -->
                    <div class="sm:col-span-3">
                        <label for="offre-type" class="block text-sm font-medium text-gray-700">
                            Type de contrat <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="offre-type" name="type_contrat" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="">Sélectionner un type</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Stage">Stage</option>
                                <option value="Alternance">Alternance</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                    </div>

                    <!-- Salary Range -->
                    <div class="sm:col-span-3">
                        <label for="offre-salary-min" class="block text-sm font-medium text-gray-700">
                            Salaire minimum
                        </label>
                        <div class="mt-1">
                            <input type="number" id="offre-salary-min" name="salaire_min"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="ex: 35000">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="offre-salary-max" class="block text-sm font-medium text-gray-700">
                            Salaire maximum
                        </label>
                        <div class="mt-1">
                            <input type="number" id="offre-salary-max" name="salaire_max"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="ex: 45000">
                        </div>
                    </div>

                    <!-- offre Description -->
                    <div class="sm:col-span-6">
                        <label for="offre-description" class="block text-sm font-medium text-gray-700">
                            Description du poste <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="offre-description" name="description" rows="5" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Décrivez les responsabilités et le contexte du poste..."></textarea>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Décrivez les principales responsabilités et le contexte du poste
                        </p>
                    </div>

                    <!-- offre Requirements -->
                    <div class="sm:col-span-6">
                        <label for="offre-requirements" class="block text-sm font-medium text-gray-700">
                            Prérequis <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="offre-requirements" name="prerequis" rows="5" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Listez les compétences et qualifications requises..."></textarea>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Énumérez les compétences, l'expérience et les qualifications requises
                        </p>
                    </div>

                    <!-- Tags / Skills -->
                    <div class="sm:col-span-6">
                        <label for="offre-tags" class="block text-sm font-medium text-gray-700">
                            Compétences et mots-clés <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md" id="tags-container">
                                <input type="text" id="tag-input" 
                                    class="outline-none border-0 flex-1 min-w-[120px] focus:ring-0"
                                    placeholder="Ajoutez des compétences et appuyez sur Entrée...">
                            </div>
                            <div id="selected-tags" class="mt-2 flex flex-wrap gap-2"></div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Ajoutez des compétences techniques, outils ou autres mots-clés pertinents
                        </p>
                    </div>
                    
                    <!-- offre Status -->
                    <div class="sm:col-span-3">
                        <label for="offre-status" class="block text-sm font-medium text-gray-700">
                            Statut de l'offre <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="offre-status" name="statut" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="brouillon">Brouillon</option>
                                <option value="ouverte">Publier immédiatement</option>
                            </select>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Vous pouvez enregistrer comme brouillon et publier plus tard
                        </p>
                    </div>

                    <!-- Submission Deadline -->
                    <div class="sm:col-span-3">
                        <label for="offre-deadline" class="block text-sm font-medium text-gray-700">
                            Date limite de candidature
                        </label>
                        <div class="mt-1">
                            <input type="date" id="offre-deadline" name="date_limite"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Laissez vide pour aucune date limite
                        </p>
                    </div>
                </div>

                <!-- Form actions -->
                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ isset($offre) ? url('/recruteur/offres/' . $offre->id) : url('/recruteur/offres') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="button" id="submit-draft" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer comme brouillon
                        </button>
                        <button type="submit" id="submit-offre" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isset($offre) ? 'Mettre à jour l\'offre' : 'Publier l\'offre' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Error notification -->
<div id="error-notification" class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50 hidden">
    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900" id="error-title">
                        Erreur
                    </p>
                    <p class="mt-1 text-sm text-gray-500" id="error-message">
                        Veuillez corriger les erreurs dans le formulaire.
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="close-error">
                        <span class="sr-only">Fermer</span>
                        <i class="fas fa-times text-lg"></i>
                    </button>
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
            // Initialize tags array
            let tags = [];
            let availableTags = [];
            
            // Cache DOM elements
            const form = document.getElementById('offre-form');
            const titleInput = document.getElementById('offre-title');
            const descriptionInput = document.getElementById('offre-description');
            const requirementsInput = document.getElementById('offre-requirements');
            const tagInput = document.getElementById('tag-input');
            const tagsContainer = document.getElementById('tags-container');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const statusSelect = document.getElementById('offre-status');
            const submitButton = document.getElementById('submit-offre');
            const saveDraftButton = document.getElementById('submit-draft');
            const offreIdInput = document.getElementById('offre-id');
            
            // Load existing tags from API
            await loadAvailableTags();
            
            // If we're in edit mode, load the offre data
            if (offreIdInput.value) {
                await loadoffreData(offreIdInput.value);
            }
            
            // Set up event listeners
            tagInput.addEventListener('keydown', handleTagInput);
            form.addEventListener('submit', handleSubmit);
            saveDraftButton.addEventListener('click', saveAsDraft);
            document.getElementById('close-error').addEventListener('click', hideErrorNotification);
            
            // Function to load available tags from API
            async function loadAvailableTags() {
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.tags) {
                        console.error('API client not available');
                        loadSampleTags();
                        return;
                    }
                    
                    // Get tags from API
                    availableTags = await window.tags.getAll();
                } catch (error) {
                    console.error('Error loading tags:', error);
                    loadSampleTags();
                }
            }
            
            // Function to load sample tags for demo purposes
            function loadSampleTags() {
                availableTags = [
                    { id: 1, nom: 'JavaScript' },
                    { id: 2, nom: 'PHP' },
                    { id: 3, nom: 'React' },
                    { id: 4, nom: 'Vue.js' },
                    { id: 5, nom: 'Laravel' },
                    { id: 6, nom: 'Python' },
                    { id: 7, nom: 'Java' },
                    { id: 8, nom: 'C#' },
                    { id: 9, nom: 'Node.js' },
                    { id: 10, nom: 'SQL' },
                    { id: 11, nom: 'MongoDB' },
                    { id: 12, nom: 'AWS' },
                    { id: 13, nom: 'Docker' },
                    { id: 14, nom: 'Git' },
                    { id: 15, nom: 'Agile' }
                ];
            }
            
            // Function to load offre data for editing
            async function loadoffreData(offreId) {
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.annonces) {
                        console.error('API client not available');
                        return;
                    }
                    
                    // Get offre data from API
                    const offre = await window.annonces.getById(offreId);
                    
                    // Fill form with offre data
                    titleInput.value = offre.titre || '';
                    document.getElementById('offre-location').value = offre.lieu || '';
                    document.getElementById('offre-type').value = offre.type_contrat || '';
                    document.getElementById('offre-salary-min').value = offre.salaire_min || '';
                    document.getElementById('offre-salary-max').value = offre.salaire_max || '';
                    descriptionInput.value = offre.description || '';
                    requirementsInput.value = offre.prerequis || '';
                    statusSelect.value = offre.statut || 'brouillon';
                    
                    // Set deadline if exists
                    if (offre.date_limite) {
                        // Format date for input (YYYY-MM-DD)
                        const deadlineDate = new Date(offre.date_limite);
                        const formattedDate = deadlineDate.toISOString().split('T')[0];
                        document.getElementById('offre-deadline').value = formattedDate;
                    }
                    
                    // Add tags if they exist
                    if (offre.tags && offre.tags.length > 0) {
                        offre.tags.forEach(tag => {
                            addTag(tag.nom, tag.id);
                        });
                    }
                } catch (error) {
                    console.error('Error loading offre data:', error);
                    window.showNotification('Erreur lors du chargement des données de l\'offre', 'error');
                }
            }
            
            // Handle tag input (Enter key)
            function handleTagInput(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const tagName = tagInput.value.trim();
                    
                    if (tagName) {
                        // Check if this tag already exists
                        const existingTag = availableTags.find(tag => 
                            tag.nom.toLowerCase() === tagName.toLowerCase()
                        );
                        
                        if (existingTag) {
                            // Use existing tag if not already added
                            if (!tags.some(tag => tag.id === existingTag.id)) {
                                addTag(existingTag.nom, existingTag.id);
                            }
                        } else {
                            // Create new tag (will be saved with offre)
                            const newTagId = 'new_' + Date.now(); // Temporary ID
                            addTag(tagName, newTagId);
                        }
                        
                        // Clear input
                        tagInput.value = '';
                    }
                }
            }
            
            // Add a tag to the UI and tags array
            function addTag(tagName, tagId) {
                // Add to tags array
                tags.push({ id: tagId, nom: tagName });
                
                // Create tag element
                const tagElement = document.createElement('div');
                tagElement.className = 'bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full flex items-center';
                tagElement.dataset.tagId = tagId;
                
                // Tag content
                tagElement.innerHTML = `
                    <span>${tagName}</span>
                    <button type="button" class="ml-1 text-blue-600 hover:text-blue-800 focus:outline-none">
                        <i class="fas fa-times-circle"></i>
                    </button>
                `;
                
                // Add delete event
                tagElement.querySelector('button').addEventListener('click', function() {
                    // Remove from array
                    tags = tags.filter(tag => tag.id !== tagId);
                    // Remove from UI
                    tagElement.remove();
                });
                
                // Add to container
                selectedTagsContainer.appendChild(tagElement);
            }
            
            // Function to save offre as draft
            function saveAsDraft() {
                // Set status to draft
                statusSelect.value = 'brouillon';
                // Submit form
                handleSubmit(null, true);
            }
            
            // Handle form submission
            async function handleSubmit(event, isDraft = false) {
                if (event) {
                    event.preventDefault();
                }
                
                // Validate form
                if (!isDraft && !validateForm()) {
                    return;
                }
                
                try {
                    // Check if API client is available
                    if (!window.apiClient || !window.annonces) {
                        console.error('API client not available');
                        simulateSubmission();
                        return;
                    }
                    
                    // Prepare offre data
                    const offreData = {
                        titre: titleInput.value.trim(),
                        lieu: document.getElementById('offre-location').value.trim(),
                        type_contrat: document.getElementById('offre-type').value,
                        salaire_min: document.getElementById('offre-salary-min').value,
                        salaire_max: document.getElementById('offre-salary-max').value,
                        description: descriptionInput.value.trim(),
                        prerequis: requirementsInput.value.trim(),
                        statut: statusSelect.value,
                        date_limite: document.getElementById('offre-deadline').value || null,
                        tags: tags.map(tag => {
                            // If it's a new tag (temporary ID starting with "new_")
                            if (String(tag.id).startsWith('new_')) {
                                return { nom: tag.nom };
                            }
                            return { id: tag.id, nom: tag.nom };
                        })
                    };
                    
                    // Disable submit button to prevent double submission
                    submitButton.disabled = true;
                    saveDraftButton.disabled = true;
                    
                    // Add loading indicator
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';
                    
                    // Submit to API (create or update)
                    let response;
                    if (offreIdInput.value) {
                        // Update existing offre
                        response = await window.annonces.update(offreIdInput.value, offreData);
                    } else {
                        // Create new offre
                        response = await window.annonces.create(offreData);
                    }
                    
                    // Show success notification
                    const actionType = isDraft ? 'enregistrée comme brouillon' : (offreIdInput.value ? 'mise à jour' : 'publiée');
                    window.showNotification(`Offre ${actionType} avec succès`, 'success');
                    
                    // Redirect after brief delay
                    setTimeout(() => {
                        window.location.href = '/recruteur/offres';
                    }, 1500);
                } catch (error) {
                    console.error('Error submitting offre:', error);
                    
                    // Re-enable submit button
                    submitButton.disabled = false;
                    saveDraftButton.disabled = false;
                    submitButton.innerHTML = offreIdInput.value ? 'Mettre à jour l\'offre' : 'Publier l\'offre';
                    
                    // Show error notification
                    showErrorNotification('Erreur lors de l\'enregistrement', 'Une erreur est survenue lors de l\'enregistrement de l\'offre.');
                }
            }
            
            // Simulate submission when API client is not available
            function simulateSubmission() {
                // Disable submit button
                submitButton.disabled = true;
                saveDraftButton.disabled = true;
                
                // Add loading indicator
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';
                
                // Simulate API delay
                setTimeout(() => {
                    // Show success notification
                    const actionType = statusSelect.value === 'brouillon' ? 'enregistrée comme brouillon' : (offreIdInput.value ? 'mise à jour' : 'publiée');
                    window.showNotification(`Offre ${actionType} avec succès`, 'success');
                    
                    // Redirect after brief delay
                    setTimeout(() => {
                        window.location.href = '/recruteur/offres';
                    }, 1500);
                }, 1000);
            }
            
            // Form validation
            function validateForm() {
                let isValid = true;
                let errorMessage = '';
                
                // Check required fields
                if (!titleInput.value.trim()) {
                    titleInput.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = 'Le titre du poste est requis.';
                } else {
                    titleInput.classList.remove('border-red-500');
                }
                
                const locationInput = document.getElementById('offre-location');
                if (!locationInput.value.trim()) {
                    locationInput.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = errorMessage || 'Le lieu est requis.';
                } else {
                    locationInput.classList.remove('border-red-500');
                }
                
                const typeInput = document.getElementById('offre-type');
                if (!typeInput.value) {
                    typeInput.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = errorMessage || 'Le type de contrat est requis.';
                } else {
                    typeInput.classList.remove('border-red-500');
                }
                
                if (!descriptionInput.value.trim()) {
                    descriptionInput.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = errorMessage || 'La description du poste est requise.';
                } else {
                    descriptionInput.classList.remove('border-red-500');
                }
                
                if (!requirementsInput.value.trim()) {
                    requirementsInput.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = errorMessage || 'Les prérequis sont requis.';
                } else {
                    requirementsInput.classList.remove('border-red-500');
                }
                
                if (tags.length === 0) {
                    tagsContainer.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = errorMessage || 'Au moins une compétence ou mot-clé est requis.';
                } else {
                    tagsContainer.classList.remove('border-red-500');
                }
                
                // Show error notification if form is invalid
                if (!isValid) {
                    showErrorNotification('Formulaire incomplet', errorMessage);
                }
                
                return isValid;
            }
            
            // Show error notification
            function showErrorNotification(title, message) {
                document.getElementById('error-title').textContent = title;
                document.getElementById('error-message').textContent = message;
                document.getElementById('error-notification').classList.remove('hidden');
                
                // Auto-hide after 5 seconds
                setTimeout(hideErrorNotification, 5000);
            }
            
            // Hide error notification
            function hideErrorNotification() {
                document.getElementById('error-notification').classList.add('hidden');
            }
        } catch (error) {
            console.error('An unexpected error occurred:', error);
            window.showNotification('Une erreur inattendue s\'est produite', 'error');
        }
    });
</script>
@endsection